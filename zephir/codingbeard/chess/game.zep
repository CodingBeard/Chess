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
    * @var \CodingBeard\Chess\Game\AI
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
    }
}