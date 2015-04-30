/*
 * Board
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess;

use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Move;

class Board
{
    /*
    * @var array
    */
    public defaults = [
        [0: "0,Rook", 1: "0,Pawn", 6: "1,Pawn", 7: "1,Rook"],
        [0: "0,Knight", 1: "0,Pawn", 6: "1,Pawn", 7: "1,Knight"],
        [0: "0,Bishop", 1: "0,Pawn", 6: "1,Pawn", 7: "1,Bishop"],
        [0: "0,Queen", 1: "0,Pawn", 6: "1,Pawn", 7: "1,Queen"],
        [0: "0,King", 1: "0,Pawn", 6: "1,Pawn", 7: "1,King"],
        [0: "0,Bishop", 1: "0,Pawn", 6: "1,Pawn", 7: "1,Bishop"],
        [0: "0,Knight", 1: "0,Pawn", 6: "1,Pawn", 7: "1,Knight"],
        [0: "0,Rook", 1: "0,Pawn", 6: "1,Pawn", 7: "1,Rook"]
    ];

    /*
    * An array of Square objects for the board
    * @var array
    */
    public squares {
        get, set
    };

    /*
    * xy location of the current square
    * @var array
    */
    public location = [0, 0] {
        get, set
    };

    /*
    * Current move
    * @var bool|CodingBeard\Chess\Board\Move
    */
    public move = false {
        get, set
    };

    /*
    * Constructor
    */
    public function __construct(const bool blank = false)
    {
        int x = 0, y = 0;

        while x < 8 {
            let y = 0;
            while y < 8 {
                if isset this->defaults[x][y] && !blank {
                    let this->squares[x][y] = new Square(x, y, Piece::fromString(this->defaults[x][y]));
                }
                else {
                    let this->squares[x][y] = new Square(x, y);
                }
                let y++;
            }
            let x++;
        }
    }

    /*
    * Get the square at the current location
    */
    public function getSquare() -> <\CodingBeard\Chess\Board\Square>
    {
        return this->squares[this->location[0]][this->location[1]];
    }

    /*
    * Set a square
    */
    public function setSquare(const int x, const int y, const var piece = false)
    {
        this->squares[x][y]->setPiece(piece);
    }

    /*
    * Get the square at the current location
    */
    public function startMove() -> <\CodingBeard\Chess\Board>
    {
        let this->move = new Move(this->getSquare());
        return this;
    }

    /*
    * Move one square north
    */
    public function north() -> <\CodingBeard\Chess\Board>
    {
        if this->location[1] < 7 {
            let this->location[1] = this->location[1] + 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

    /*
    * Move one square north east
    */
    public function northeast() -> <\CodingBeard\Chess\Board>
    {
        if this->location[0] < 7 && this->location[1] < 7 {
            let this->location[0] = this->location[0] + 1;
            let this->location[1] = this->location[1] + 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

    /*
    * Move one square east
    */
    public function east() -> <\CodingBeard\Chess\Board>
    {
        if this->location[0] < 7 {
            let this->location[0] = this->location[0] + 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

    /*
    * Move one square south east
    */
    public function southeast() -> <\CodingBeard\Chess\Board>
    {
        if this->location[0] < 7 && this->location[1] > 0 {
            let this->location[0] = this->location[0] + 1;
            let this->location[1] = this->location[1] - 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

    /*
    * Move one square south
    */
    public function south() -> <\CodingBeard\Chess\Board>
    {
        if this->location[1] > 0 {
            let this->location[1] = this->location[1] - 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

    /*
    * Move one square south west
    */
    public function southwest() -> <\CodingBeard\Chess\Board>
    {
        if this->location[0] > 0 && this->location[1] > 0 {
            let this->location[0] = this->location[0] - 1;
            let this->location[1] = this->location[1] - 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

    /*
    * Move one square west
    */
    public function west() -> <\CodingBeard\Chess\Board>
    {
        if this->location[0] > 0 {
            let this->location[0] = this->location[0] - 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

    /*
    * Move one square north west
    */
    public function northwest() -> <\CodingBeard\Chess\Board>
    {
        if this->location[0] > 0 && this->location[1] < 7 {
            let this->location[0] = this->location[0] - 1;
            let this->location[1] = this->location[1] + 1;
            if this->move {
                this->move->setTo(this->getSquare());
            }
        }
        return this;
    }

}