<?php
namespace CodingBeard\Chess;

use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Square;
use models\Games;
use models\Players;
use Phalcon\Mvc\User\Component;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Websocket handler
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */
class Websocket extends Component implements MessageComponentInterface
{
    /**
     * Array of clients, keys are their players model IDs
     * @var array
     */
    public $clients = [];

    /**
     * Array of games, keys are their games model IDs
     * @var array
     */
    public $games = [];

    /**
     * When a client Connects
     * @param ConnectionInterface $client
     */
    public function onOpen(ConnectionInterface $client)
    {

    }

    /**
     * When we receive a message
     * @param ConnectionInterface $client
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $client, $msg)
    {
        $json = json_decode($msg);
        if ($json) {
            if (!isset($client->player) && $json->action != 'connect') {
                return $client->send(json_encode([
                    ['type' => 'alert', 'params' => [
                        'type' => 'modal',
                        'You must first auth before using any other functions'
                    ]]
                ]));
            }
            if (method_exists($this, $json->action)) {
                $this->{$json->action}($client, $json->params);
            }
        }
    }

    /**
     * When a client disconnects
     * @param ConnectionInterface $client
     */
    public function onClose(ConnectionInterface $client)
    {
        if (isset($client->player)) {
            unset($this->clients[$client->player->id]);
            echo "Player ({$client->player->id}) has disconnected\n";
        }
        else {
            echo "An unauthenticated client has disconnected\n";
        }
    }

    /**
     * When an error occurs
     * @param ConnectionInterface $client
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $client, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $client->close();
    }

    /**
     * On the initial connection set their player ID and add them to our clients
     * @param ConnectionInterface $client
     * @param $params
     * @return string
     */
    public function connect(ConnectionInterface $client, $params)
    {
        $player = Players::findFirstByToken($params->token);
        if (!$player) {
            $player = new Players();
            $player->token = $params->token;
            $player->save();
        }

        $client->player = $player;

        $this->clients[$player->id] = $client;
        echo "Player ({$player->id}) has connected\n";
        $client->send(json_encode([
            ['type' => 'alert', 'params' => [
                'type' => 'toast',
                'message' => 'Connected'
            ]]
        ]));
    }

    /**
     * Start a new game type
     * @param ConnectionInterface $client
     * @param $params
     * @return string
     */
    public function newGame(ConnectionInterface $client, $params)
    {
        switch ($params->type) {
            case "multiLocal":
                return $this->newMutiLocal($client, $params);
            case "aiLocal":

        }
    }

    /**
     * Start a new Multiplayer local game
     * @param ConnectionInterface $client
     * @param $params
     * @return string
     */
    public function newMutiLocal(ConnectionInterface $client, $params)
    {
        $gameModel = new Games();
        $gameModel->type = "multiLocal";
        $gameModel->turn = Piece::WHITE;
        $gameModel->playerW_id = $client->player->id;
        $gameModel->playerB_id = $client->player->id;
        $gameModel->save();

        $board = new Board();
        $board->setDefaults();
        $game = new Game($board);

        $gameModel->game = $game;

        $this->games[$gameModel->id] = $gameModel;

        $client->send(json_encode([
            ['type' => 'alert', 'params' => [
                'type' => 'toast',
                'message' => 'New game started, white to go first',
            ]],
            ['type' => 'addPieces', 'params' => [
                'pieces' => $board->toArray()
            ]],
            ['type' => 'setGame', 'params' => [
                'id' => $gameModel->id,
                'turn' => $gameModel->turn
            ]]
        ]));
    }

    /**
     * Find the game from the gamdId
     * @param ConnectionInterface $client
     * @param $params
     * @return bool|Games
     */
    public function getGameModel(ConnectionInterface $client, $params)
    {
        /** @var Games $gameModel */
        $gameModel = $this->games[$params->gameId];
        if (!$gameModel) {
            $gameModel = Games::findFirstById($params->gameId);
        }
        /* No gameId matching a game we have, send an error */
        if (!$gameModel) {
            $client->send(json_encode([
                ['type' => 'alert', 'params' => [
                    'type' => 'modal',
                    'message' => 'You do not have a game to check a move for.' . $params->get,
                ]]
            ]));
            return false;
        }
        return $gameModel;
    }

    /**
     * Check that it is their turn, and the move is within the pieces moves, send error and revert if not
     * @param ConnectionInterface $client
     * @param Game $game
     * @param Move $move
     * @return bool
     */
    public function checkBasicMove(ConnectionInterface $client, $game, $move)
    {
        $response = $game->checkMove($move);
        if ($response != Ai::VALID_MOVE) {
            if ($response == Ai::NOT_TURN) {
                $toast = "Not your turn";
            }
            else if ($response == Ai::INVALID_MOVE) {
                $toast = "Invalid move";
            }
            $client->send(json_encode([
                ['type' => 'alert', 'params' => [
                    'type' => 'toast',
                    'message' => $toast,
                ]],
                ['type' => 'invalidMove'],
            ]));
            return false;
        }
        return true;
    }

    /**
     * Check if a move is legal, if not send an invalid notice and move the piece back
     * @param ConnectionInterface $client
     * @param $params
     * @return bool|string
     */
    public function checkMove(ConnectionInterface $client, $params)
    {
        /* Make sure the client has a game */
        if (!($gameModel = $this->getGameModel($client, $params))) {
            return false;
        }

        /** @var \CodingBeard\Chess\Game $game */
        $game = $gameModel->game;
        $move = $this->moveToPhp($params->move);

        /* Make sure the move is basically correct */
        if (!$this->checkBasicMove($client, $game, $move)) {
            return false;
        }

        /* If the current player is in check, we need to make sure they move to get out of check, otherwise error */
        $currentTurn = $game->getTurn();
        if ($game->isCheck($currentTurn)) {
            $toast = "You must escape Check";
        }
        /* We also need to make sure they don't put themselves in check */
        else {
            $toast = "You cannot enter Check";
        }

        /* Make the proposed move */
        $game->getBoard()->makeMove($move);

        /* See if the move they made put them in check, if so undo move and send error */
        if ($game->isCheck($currentTurn)) {
            $game->getBoard()->undoMove($move);
            return $client->send(json_encode([
                ['type' => 'alert', 'params' => [
                    'type' => 'toast',
                    'message' => $toast,
                ]],
                ['type' => 'invalidMove'],
            ]));
        }

        /* They weren't in check, nor did they put themselves in check. But they have put the other player in check */
        if ($game->isCheck($game->getTurn())) {
            if (!$game->isCheckMate($game->getTurn())) {
                $client->send(json_encode([
                    ['type' => 'alert', 'params' => [
                        'type' => 'toast',
                        'message' => 'Check!',
                    ]]
                ]));
            }
            else {
                $client->send(json_encode([
                    ['type' => 'alert', 'params' => [
                        'type' => 'toast',
                        'message' => 'Checkmate!',
                    ]]
                ]));
            }
        }

        if ($game->getTurn() == Piece::WHITE) {
            $toast = "White's turn";
        }
        else {
            $toast = "Black's turn";
        }

        $gameModel->save();

        return $client->send(json_encode([
            ['type' => 'alert', 'params' => [
                'type' => 'toast',
                'message' => $toast,
            ]],
            ['type' => 'setGame', 'params' => [
                'id' => $gameModel->id,
                'turn' => $game->getTurn()
            ]]
        ]));
    }

    /**
     * Convert a json move to a Move object
     * @param $jsMove
     * @return Move
     */
    public function moveToPhp($jsMove)
    {
        if ($jsMove->to->piece) {
            return new Move(
                new Square(
                    $jsMove->from->x - 1,
                    $jsMove->from->y - 1,
                    Piece::fromString(json_encode($jsMove->from->piece))
                ),
                new Square(
                    $jsMove->to->x - 1,
                    $jsMove->to->y - 1,
                    Piece::fromString(json_encode($jsMove->to->piece))
                )
            );
        }
        else {
            return new Move(
                new Square(
                    $jsMove->from->x - 1,
                    $jsMove->from->y - 1,
                    Piece::fromString(json_encode($jsMove->from->piece))
                ),
                new Square(
                    $jsMove->to->x - 1,
                    $jsMove->to->y - 1
                )
            );
        }
    }

    /**
     * Get the available moves to a piece on the board
     * @param ConnectionInterface $client
     * @param $params
     * @return bool|string
     */
    public function getMoves(ConnectionInterface $client, $params)
    {
        /* Make sure the client has a game */
        if (!($gameModel = $this->getGameModel($client, $params))) {
            return false;
        }
        $game = $gameModel->game;
        $moves = $game->getBoard()->getMoves($params->location->x - 1, $params->location->y - 1);

        $toLocations = [];
        if ($moves) {
            /** @var Move $move */
            foreach ($moves as $move) {
                $toLocations[] = ['x' => $move->getTo()->getX() + 1, 'y' => $move->getTo()->getY() + 1];
            }
        }

        $client->send(json_encode([[
            'type' => 'highlightSquares',
            'params' => $toLocations
        ]]));
    }
}
