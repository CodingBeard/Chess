/**
 * Pawn
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Pieces;

use CodingBeard\Chess\Piece;

class Pawn extends Piece
{
    /**
    * @var string
    */
    public type = "Pawn" {
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
            [0, 1], //N
            [0, 2], //N
            [1, 1], //NE
            [-1, 1] //NW
        ];
        let this->colour = colour;
    }

}