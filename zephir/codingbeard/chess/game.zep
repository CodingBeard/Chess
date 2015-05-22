/**
 * Game
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess;

class Game
{
    /**
    * @var \CodingBeard\Chess\Board
    */
    public board {
        get, set
    };

    /**
    * @var \CodingBeard\Chess\Ai
    */
    public ai {
        get, set
    };

    /**
    * Constructor
    * @param \CodingBeard\Chess\Board board
    */
    public function __construct(const <\CodingBeard\Chess\Board> board = null)
    {
        if board {
            let this->board = board;
        }
        else {
            let this->board = new Board();
        }
        let this->ai = new Ai();
    }

    /**
    * Get the turn of the board
    */
    public function getTurn() -> int
    {
        return this->board->getTurn();
    }

    /**
    * Set the turn of the board
    */
    public function setTurn(const int turn)
    {
        return this->board->setTurn(turn);
    }

    /**
    * Alias of Ai::checkMove
    * Check whether a move is within an array of moves
    * @param \CodingBeard\Chess\Board\Move move
    */
    public function checkMove(const <\CodingBeard\Chess\Board\Move> move) -> int
    {
        return this->ai->checkMove(move, this->board);
    }

    /**
    * Alias of Ai::isCheck
    * Check whether a colour's king is in check
    * @param int colourToCheck
    */
    public function isCheck(const int colourToCheck) -> bool
    {
        return this->ai->isCheck(this->board, colourToCheck);
    }

    /**
    * Alias of Ai::isCheckMate
    * Check whether a colour's king is in checkmate
    * @param int colourToCheck
    */
    public function isCheckMate(const int colourToCheck) -> bool
    {
        if empty this->board->getPossibleMoves() {
            this->board->setPossibleMoves();
        }
        return this->ai->isCheckMate(this->board, colourToCheck);
    }
}