/**
 * Move
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Board;

use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Rook;
use CodingBeard\Chess\Board\Piece\Pawn;

class Move
{
    /**
    * @var \CodingBeard\Chess\Board\Square
    */
    public from {
        get, set
    };

    /**
    * @var \CodingBeard\Chess\Board\Square
    */
    public to {
        get, set
    };

    /**
    * @var bool|\CodingBeard\Chess\Board\Move
    */
    public doubleMove = false {
        get, set
    };

    /**
    * @var bool
    */
    public attack = false {
        get, set
    };

    /**
    * Constructor
    * @param \CodingBeard\Chess\Board\Move from
    * @param \CodingBeard\Chess\Board\Move to
    */
    public function __construct(const <\CodingBeard\Chess\Board\Square> from = null, <\CodingBeard\Chess\Board\Square>
     to = null, const <\CodingBeard\Chess\Board\Move> doubleMove = null)
    {
        if from {
            let this->from = from;
        }
        if to {
            let this->to = to;
            if from->getPiece() && to->getPiece() {
                if to->getPiece()->getColour() != from->getPiece()->getColour() {
                    let this->attack = true;
                }
            }
        }
        if doubleMove {
            let this->doubleMove = doubleMove;
        }

        if from {
            if from->getPiece() {
                if from->getY() == 0 || from->getY() == 7 {
                    if from->getPiece()->getType() == "King" {
                        if abs(from->getX() - to->getX()) == 2 {
                            if to->getX() == 2 && to->getY() == 0 {
                                let this->doubleMove = new self(
                                    new Square(0, 0, new Rook(Piece::WHITE)), new Square(3, 0)
                                );
                            }
                            elseif to->getX() == 6 && to->getY() == 0 {
                                let this->doubleMove = new self(
                                    new Square(7, 0, new Rook(Piece::WHITE)), new Square(5, 0)
                                );
                            }
                            elseif to->getX() == 2 && to->getY() == 7 {
                                let this->doubleMove = new self(
                                    new Square(0, 7, new Rook(Piece::BLACK)), new Square(3, 7)
                                );
                            }
                            elseif to->getX() == 6 && to->getY() == 7 {
                                let this->doubleMove = new self(
                                    new Square(7, 7, new Rook(Piece::BLACK)), new Square(5, 7)
                                );
                            }
                        }
                    }
                }
                elseif from->getY() == 3 || from->getY() == 4 {
                    if from->getPiece()->getType() == "Pawn" && from->getX() != to->getX() && !to->getPiece() {
                        if from->getPiece()->getColour() == Piece::WHITE {
                            let this->doubleMove = new self(
                                new Square(to->getX(), to->getY() - 1, new Pawn(Piece::BLACK)),
                                new Square(to->getX(), to->getY())
                            );
                        }
                        elseif from->getPiece()->getColour() == Piece::BLACK {
                            let this->doubleMove = new self(
                                new Square(to->getX(), to->getY() + 1, new Pawn(Piece::WHITE)),
                                new Square(to->getX(), to->getY())
                            );
                        }
                    }
                }
            }
            else {
                throw new \Exception("A move's from square must contain a piece.");
            }
        }
    }

    /**
    * Clone the squares if this move is cloned
    */
    public function __clone()
    {
        let this->from = clone this->from;
        let this->to = clone this->to;
    }

}