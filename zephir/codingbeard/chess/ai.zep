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
    public function checkMove(
        const <\CodingBeard\Chess\Board\Move> checkMove,
        const <\CodingBeard\Chess\Board> board
    ) -> bool
    {
        var move, moves;

        if move->getFrom()->getPiece()->getColour() != board->getTurn() {
            return false;
        }

        let moves = board->getMoves(move->getFrom()->getX(), move->getFrom()->getY());

        if in_array(move, moves) {
            return true;
        }
        return false;
    }
}