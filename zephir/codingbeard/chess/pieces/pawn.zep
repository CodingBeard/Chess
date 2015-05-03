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
        let this->colour = colour;
    }

    /**
    * Return all the squares this piece could potentially move to
    * @param int x
    * @param int y
    */
    public function getPotentialMoves(const int x, const int y) -> array
    {
        var moves = [];

        if this->getColour() == Piece::WHITE {
            /* N */
            if 8 > (x + 0) && (x + 0) > -1 && 8 > (y + 1) && (y + 1) > -1 {
                let moves[0][] = [(x + 0), (y + 1)];
            }
            /* NN */
            if 8 > (x + 0) && (x + 0) > -1 && 8 > (y + 2) && (y + 2) > -1 {
                let moves[0][] = [(x + 0), (y + 2)];
            }
            /* NE */
            if 8 > (x + 1) && (x + 1) > -1 && 8 > (y + 1) && (y + 1) > -1 {
                let moves[1][] = [(x + 1), (y + 1)];
            }
            /* NW */
            if 8 > (x + -1) && (x + -1) > -1 && 8 > (y + 1) && (y + 1) > -1 {
                let moves[2][] = [(x + -1), (y + 1)];
            }
        }
        else {
            /* S */
            if 8 > (x + 0) && (x + 0) > -1 && 8 > (y + -1) && (y + -1) > -1 {
                let moves[0][] = [(x + 0), (y + -1)];
            }
            /* SS */
            if 8 > (x + 0) && (x + 0) > -1 && 8 > (y + -2) && (y + -2) > -1 {
                let moves[0][] = [(x + 0), (y + -2)];
            }
            /* SE */
            if 8 > (x + 1) && (x + 1) > -1 && 8 > (y + -1) && (y + -1) > -1 {
                let moves[1][] = [(x + 1), (y + -1)];
            }
            /* SW */
            if 8 > (x + -1) && (x + -1) > -1 && 8 > (y + -1) && (y + -1) > -1 {
                let moves[2][] = [(x + -1), (y + -1)];
            }
        }

        return array_values(moves);
    }

    /**
    * Check a move to see if we can do it
    * @param \CodingBeard\Chess\Board\Square from
    * @param \CodingBeard\Chess\Board\Square to
    */
    public function checkMove(const <\CodingBeard\Chess\Board\Square> from, const <\CodingBeard\Chess\Board\Square> to)
    -> bool
    {
        if to->getPiece() {
            if from->getPiece()->getColour() != to->getPiece()->getColour() {
                if from->getX() != to->getX() {
                    return [true, "break": true];
                }
                else {
                    return [false, "break": true];
                }
            }
            else {
                return [false, "break": true];
            }
        }
        else {
            if abs(from->getY() - to->getY()) == 2 {
                if this->colour == parent::WHITE && from->getY() == 1 && to->getY() == 3 {
                    return [true, "break": false];
                }
                elseif this->colour == parent::BLACK && from->getY() == 6 && to->getY() == 4 {
                    return [true, "break": false];
                }
                else {
                    return [false, "break": true];
                }
            }
            elseif from->getX() != to->getX() {
                return [false, "break": true];
            }
        }
        return [true, "break": false];
    }

}