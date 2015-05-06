/**
 * Queen
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Board\Piece;

use CodingBeard\Chess\Board\Piece;

class Queen extends Piece
{
    /**
    * @var string
    */
    public type = "Queen" {
        get, set
    };

    /**
    * Constructor
    * @param int colour
    */
    public function __construct(const int colour)
    {
        let this->range = 7;
        let this->directions = [
            [0, 1], //N
            [1, 1], //NE
            [1, 0], //E
            [1, -1], //SE
            [0, -1], //S
            [-1, -1], //SW
            [-1, 0], //W
            [-1, 1] //NW
        ];
        let this->colour = colour;
    }

}