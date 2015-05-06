/**
 * Piece
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Board;

abstract class Piece
{
    /**
    * @var string
    */
    public type {
        get, set
    };

    /**
    * @var int
    */
    public colour {
        get, set
    };

    /**
    * @var int
    */
    public range {
        get, set
    };

    /**
    * @var array
    */
    public directions {
        get, set
    };

    const WHITE = 0;

    const BLACK = 1;


    /**
    * Return all the squares this piece could potentially move to
    * @param int x
    * @param int y
    */
    public function getPotentialMoves(const int x, const int y) -> array
    {
        array moves;
        int distance = 1;
        var direction, key;

        let moves = [];
        for key, direction in this->directions {
            while distance <= this->range {

                if 8 > (x + (distance * direction[0])) && (x + (distance * direction[0])) > -1 {
                    if 8 > (y + (distance * direction[1])) && (y + (distance * direction[1])) > -1 {
                        let moves[key][] = [(x + (distance * direction[0])), (y + (distance * direction[1]))];
                    }
                }

                let distance++;
            }
            let distance = 1;
        }
        return array_values(moves);
    }

    /**
    * Check a move to see if we can do it
    * @param \CodingBeard\Chess\Board\Square from
    * @param \CodingBeard\Chess\Board\Square to
    */
    public function checkMove(const <\CodingBeard\Chess\Board\Square> from, const <\CodingBeard\Chess\Board\Square> to)
    -> array
    {
        if to->getPiece() {
            if from->getPiece()->getColour() != to->getPiece()->getColour() {
                return [true, "break": true];
            }
            else {
                return [false, "break": true];
            }
        }
        return [true, "break": false];
    }

    /**
    * Stringify self
    */
    public function toString(const bool image = false) -> string
    {
        if image {
            if this->colour {
                return "b" . substr(this->type, 0, 1);
            }
            else {
                return "w" . substr(this->type, 0, 1);
            }
        }
        return json_encode([this->colour, this->type]);
    }

    /**
    * Instance a piece from its string representation
    * @param string piece
    */
    public static function fromString(const string piece) -> <\CodingBeard\Chess\Board\Piece>
    {
        var parts = [], name, colour;
        let parts = json_decode(piece);

        if parts[0] != self::WHITE && parts[0] != self::BLACK {
            throw new \Exception(parts[0] . " is not a valid piece colour.");
        }

        if !in_array(parts[1], ["King", "Queen", "Rook", "Bishop", "Knight", "Pawn"]) {
            throw new \Exception(parts[1] . " is not a valid piece type.");
        }

        let name = "\\CodingBeard\\Chess\\Board\\Piece\\" . parts[1], colour = parts[0];

        return new {name}(colour);
    }
}