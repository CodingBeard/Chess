/**
 * Knight
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Pieces;

use CodingBeard\Chess\Piece;

class Knight extends Piece
{
    /**
    * @var string
    */
    public type = "Knight" {
        get, set
    };

    /**
    * Constructor
    * @param int colour
    */
    public function __construct(const int colour)
    {
        let this->range = 1;
        let this->directions = [
            [1, 2], //NNE
            [2, 1], //NEE
            [2, -1], //SEE
            [1, -2], //SSE
            [-1, -2], //SSW
            [-2, -1], //SWW
            [-2, 1], //NWW
            [-1, 2] //NNW
        ];
        let this->colour = colour;
    }

}