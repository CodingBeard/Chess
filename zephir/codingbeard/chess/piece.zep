/*
 * Piece
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess;

abstract class Piece
{
    /*
    * @var string
    */
    public type {
        get, set
    };

    /*
    * @var int
    */
    public colour {
        get, set
    };

    const WHITE = 0;

    const BLACK = 1;

    /*
    * Constructor
    * @param int colour
    */
    public function __construct(const int colour)
    {
        let this->colour = colour;
    }

    /*
    * Stringify self
    */
    public function toString() -> string
    {
        return strval(this->colour) . "," . this->type;
    }

    /*
    * Instance a piece from its string representation
    * @param string piece
    */
    public static function fromString(const string piece) -> <\CodingBeard\Chess\Piece>
    {
        var parts, name, colour;
        let parts = str_getcsv(piece, ",", "'");

        if parts[0] != self::WHITE && parts[0] != self::BLACK {
            throw new \Exception(parts[0] . " is not a valid piece colour.");
        }

        if !in_array(parts[1], ["King", "Queen", "Rook", "Bishop", "Knight", "Pawn"]) {
            throw new \Exception(parts[1] . " is not a valid piece type.");
        }

        let name = "\\CodingBeard\\Chess\\Pieces\\" . parts[1], colour = parts[0];

        return new {name}(colour);
    }
}