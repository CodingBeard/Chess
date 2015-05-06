/**
 * Rook
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Board\Piece;

use CodingBeard\Chess\Board\Piece;

class Rook extends Piece
{
    /**
    * @var string
    */
    public type = "Rook" {
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
            [1, 0], //E
            [0, -1], //S
            [-1, 0] //W
        ];
        let this->colour = colour;
    }

}