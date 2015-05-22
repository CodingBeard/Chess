/**
 * Ai
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess;

class Ai
{

    const NOT_TURN = -1;
    const INVALID_MOVE = 0;
    const VALID_MOVE = 1;

    /**
    * Constructor
    * @param \CodingBeard\Chess\Board board
    */
    public function __construct()
    {

    }

    /**
    * Check whether a move is within an array of moves
    * @param \CodingBeard\Chess\Board\Move move
    * @param \CodingBeard\Chess\Board board
    */
    public function checkMove(const <\CodingBeard\Chess\Board\Move> move, const <\CodingBeard\Chess\Board> board) -> int
    {
        var moves;

        if move->getFrom()->getPiece()->getColour() != board->getTurn() {
            return self::NOT_TURN;
        }

        let moves = board->getMoves(move->getFrom()->getX(), move->getFrom()->getY());

        if in_array(move, moves) {
            return self::VALID_MOVE;
        }
        return self::INVALID_MOVE;
    }

    /**
    * Check whether a colour's king is in check
    * @param \CodingBeard\Chess\Board board
    * @param int colourToCheck
    */
    public function isCheck(const <\CodingBeard\Chess\Board> board, const int colourToCheck) -> bool
    {
        var move, colour, colourMoves, moves;

        board->setPossibleMoves();
        let moves = board->getPossibleMoves();

        for colour, colourMoves in moves {
            if  colour == colourToCheck {
                continue;
            }
            for move in colourMoves {
                if !move->getTo()->getPiece() {
                    continue;
                }
                if move->getTo()->getPiece()->getType() != "King" {
                    continue;
                }
                if move->getTo()->getPiece()->getColour() != colourToCheck {
                    continue;
                }
                return true;
            }
        }
        return false;
    }

    /**
    * Check whether a colour's king is in checkmate
    * @param \CodingBeard\Chess\Board board
    * @param int colourToCheck
    */
    public function isCheckMate(<\CodingBeard\Chess\Board> board, const int colourToCheck) -> bool
    {
        var move, colour, colourMoves, moves;

        let board = clone board;

        let moves = board->getPossibleMoves();

        for colour, colourMoves in moves {
            if  colour != colourToCheck {
                continue;
            }
            for move in colourMoves {
                echo move->from->x . " " . move->from->y . " -> " . move->to->x . " " . move->to->y . PHP_EOL;
                board->makeMove(move);
                if !this->isCheck(board, colourToCheck) {
                    board->undoMove(move);
                    return false;
                }
                board->undoMove(move);
            }
        }
        return true;
    }
}