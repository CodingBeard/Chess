/**
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
    /**
    * @var array
    */
    public defaults = [
        [0: "[0,\"Rook\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"Rook\"]"],
        [0: "[0,\"Knight\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"Knight\"]"],
        [0: "[0,\"Bishop\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"Bishop\"]"],
        [0: "[0,\"Queen\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"Queen\"]"],
        [0: "[0,\"King\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"King\"]"],
        [0: "[0,\"Bishop\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"Bishop\"]"],
        [0: "[0,\"Knight\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"Knight\"]"],
        [0: "[0,\"Rook\"]", 1: "[0,\"Pawn\"]", 6: "[1,\"Pawn\"]", 7: "[1,\"Rook\"]"]
    ];

    /**
    * An array of Square objects for the board
    * @var array
    */
    public squares {
        get, set
    };

    /**
    * Constructor
    * @param bool blank whether to generate a blank board or not
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

    /**
    * Get the square at a location
    * @param int x
    * @param int y
    */
    public function getSquare(const int x, const int y) -> <\CodingBeard\Chess\Board\Square>
    {
        if (0 > x && x > 7) || (0 > y && y > 7) {
            throw new \Exception(strval(x) . strval(y) . " is not a valid location.");
        }
        return this->squares[x][y];
    }

    /**
    * Set a square at a location
    * @param int x
    * @param int y
    * @param \CodingBeard\Chess\Piece piece
    */
    public function setSquare(const int x, const int y, const var piece = false) -> <\CodingBeard\Chess\Board>
    {
        this->squares[x][y]->setPiece(piece);
        return this;
    }

    /**
    * Get the moves of a piece at a location
    * @param int x
    * @param int y
    */
    public function getMoves(const int x, const int y) -> bool|array
    {
        var from, to, direction, location, response;
        array moves;

        let from = this->getSquare(x, y);

        if from->getPiece() {
            let moves = [];

            for direction in from->getPiece()->getPotentialMoves(x, y) {

                for location in direction {

                    let to = this->getSquare(location[0], location[1]);
                    let response = from->getPiece()->checkMove(from, to);

                    if response[0] {
                        let moves[] = new Move(from, to);
                    }
                    if response["break"] {
                        break;
                    }
                }
            }
            return moves;
        }
        else {
            return false;
        }
    }

    /**
    * Make a move on the board
    * @param \CodingBeard\Chess\Board\Move move
    */
    public function makeMove(const <\CodingBeard\Chess\Board\Move> move)
    {
        if move->getDoubleMove() {
            this->makeMove(move->getDoubleMove());
        }

        this->setSquare(move->getTo()->getX(), move->getTo()->getY(), move->getFrom()->getPiece());
        this->setSquare(move->getFrom()->getX(), move->getFrom()->getY(), false);
    }

    /**
    * Make a move on the board
    * @param \CodingBeard\Chess\Board\Move move
    */
    public function undoMove(const <\CodingBeard\Chess\Board\Move> move)
    {
        this->setSquare(move->getTo()->getX(), move->getTo()->getY(), move->getTo()->getPiece());
        this->setSquare(move->getFrom()->getX(), move->getFrom()->getY(), move->getFrom()->getPiece());

        if move->getDoubleMove() {
            this->undoMove(move->getDoubleMove());
        }
    }

    /**
    * Print out the board in human readable format
    */
    public function printBoard() -> string
    {
        string board = "";
        int x = 0, y = 7;

        let board .=  PHP_EOL . "   | 0  | 1  | 2  | 3  | 4  | 5  | 6  | 7  |   " . PHP_EOL;

        while y > -1 {
            let x = 0;
            let board .= "-----------------------------------------------" . PHP_EOL;
            let board .= strval(y) . "  | ";
            while x < 8 {
                let board .= this->getSquare(x, y)->toString(true) . " | ";
                let x++;
            }
            let board .= "  " . strval(y) . PHP_EOL;
            let y--;
        }

        let board .= "-----------------------------------------------" . PHP_EOL;
        let board .= "   | 0  | 1  | 2  | 3  | 4  | 5  | 6  | 7  |   " . PHP_EOL;
        return board;
    }

}