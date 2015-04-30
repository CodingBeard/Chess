/*
 * Square
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Board;

use CodingBeard\Chess\Piece;

class Square
{
    /*
    * @var int
    */
    public x {
        get, set
    };

    /*
    * @var int
    */
    public y {
        get, set
    };

    /*
    * @var false|\CodingBeard\Chess\Piece
    */
    public piece = false {
        get, set
    };

    /*
    * Constructor
    * @param int x
    * @param int y
    * @param \CodingBeard\Chess\Piece piece
    */
    public function __construct(const int x, const int y, const var piece = null)
    {
        let this->x = x;
        let this->y = y;
        if piece {
            let this->piece = piece;
        }
    }

    /*
    * Stringify self
    */
    public function toString() -> string
    {
        if this->piece {
            return strval(this->x) . "," . strval(this->y) . ",'" . this->piece->toString() . "'";
        }
        else {
            return strval(this->x) . "," . strval(this->y) . ",";
        }
    }

    /*
    * Instance a square from its string representation
    * @param string square
    */
    public static function fromString(const string square) -> <\CodingBeard\Chess\Board\Square>
    {
        var parts;
        let parts = str_getcsv(square, ",", "'");

        if (0 > parts[0] > 7) || (0 > parts[1] > 7) {
            throw new \Exception(parts[0] . parts[1] . " is not a valid location.");
        }

        if strlen(parts[2]) {
            return new self(parts[0], parts[1], Piece::fromString(parts[2]));
        }
        else {
            return new self(parts[0], parts[1]);
        }
    }

}