/**
 * Bishop
 *
 * @category
 * @package
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Pieces;

use CodingBeard\Chess\Piece;

class Bishop extends Piece
{
    /**
    * @var string
    */
    public type = "Bishop" {
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
            [1, 1], //NE
            [1, -1], //SE
            [-1, -1], //SW
            [-1, 1] //NW
        ];
        let this->colour = colour;
    }

}