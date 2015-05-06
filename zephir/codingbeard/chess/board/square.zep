/**
 * Square
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Board;

use CodingBeard\Chess\Board\Piece;

class Square
{
    /**
    * @var int
    */
    public x {
        get, set
    };

    /**
    * @var int
    */
    public y {
        get, set
    };

    /**
    * @var false|\CodingBeard\Chess\Board\Piece
    */
    public piece = false {
        get, set
    };

    /**
    * Constructor
    * @param int x
    * @param int y
    * @param \CodingBeard\Chess\Board\Piece piece
    */
    public function __construct(const int x, const int y, const <\CodingBeard\Chess\Board\Piece> piece = null)
    {
        let this->x = x;
        let this->y = y;
        if piece {
            let this->piece = piece;
        }
    }

    /**
    * Stringify self
    */
    public function toString(const bool image = false) -> string
    {
        if image {
            if this->piece {
                return this->piece->toString(true);
            }
            else {
                return "  ";
            }
        }

        if this->piece {
            return json_encode([this->x, this->y, [this->piece->getColour(), this->piece->getType()]]);
        }
        else {
            return json_encode([this->x, this->y, []]);
        }
    }

    /**
    * Instance a square from its string representation
    * @param string square
    */
    public static function fromString(const string square) -> <\CodingBeard\Chess\Board\Square>
    {
        var parts = [], name, colour;

        let parts = json_decode(square);

        if (0 > parts[0] && parts[0] > 7) || (0 > parts[1] && parts[1] > 7) {
            throw new \Exception(parts[0] . parts[1] . " is not a valid location.");
        }

        if typeof parts[2] == "array" {

            if parts[2][0] != Piece::WHITE && parts[2][0] != Piece::BLACK {
                throw new \Exception(parts[2][0] . " is not a valid piece colour.");
            }

            if !in_array(parts[2][1], ["King", "Queen", "Rook", "Bishop", "Knight", "Pawn"]) {
                throw new \Exception(parts[2][1] . " is not a valid piece type.");
            }

            let name = "\\CodingBeard\\Chess\\Board\\Piece\\" . parts[2][1], colour = parts[2][0];

            return new self(parts[0], parts[1], new {name}(colour));
        }
        else {
            return new self(parts[0], parts[1]);
        }
    }

}