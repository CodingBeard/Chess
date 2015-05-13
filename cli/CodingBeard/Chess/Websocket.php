<?php
namespace CodingBeard\Chess;

use CodingBeard\Chess\Board\Piece;
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
                        'type' => 'error',
                        'body' => 'You must first auth before using any other functions.'
                    ]]
                ]));
            }
            if (method_exists($this, $json->action)) {
                $client->send($this->{$json->action}($client, $json->params));
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
        return json_encode([
            ['type' => 'alert', 'params' => [
                'type' => 'log',
                'body' => 'Connected.'
            ]]
        ]);
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

        return json_encode([
            ['type' => 'alert', 'params' => [
                'type' => 'alert',
                'body' => 'New game started, White to go first.'
            ]],
            ['type' => 'addPieces', 'params' => [
                'pieces' => $board->toArray()
            ]]
        ]);
    }
}
