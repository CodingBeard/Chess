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

use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Square;

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
    * An array of the moves that have been played
    * @var array
    */
    public history = [] {
        get, set
    };

    /**
    * @var int
    */
    public turn {
        get, set
    };

    /**
    * An array of the moves pieces on the board can make
    * @var array
    */
    public possibleMoves = [] {
        get
    };

    /**
    * Constructor
    * @param int turn
    */
    public function __construct(const int turn = 0)
    {
        int x = 0, y = 0;

        while x < 8 {
            let y = 0;
            while y < 8 {
                let this->squares[x][y] = new Square(x, y);
                let y++;
            }
            let x++;
        }
        let this->turn = turn;
    }

    /**
    * Set the board up with default pieces
    */
    public function setDefaults()
    {
        var x, y, column, pieceString;

        for x, column in this->defaults {
            for y, pieceString in column {
                this->setSquare(x, y, Piece::fromString(pieceString));
            }
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
    * @param \CodingBeard\Chess\Board\Piece piece
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
            if from->getPiece()->getType() == "King" {
                let moves = this->checkForCastling(from, moves);
            }
            elseif from->getPiece()->getType() == "Pawn" {
                let moves = this->checkForEnPassant(from, moves);
            }
            return moves;
        }
        else {
            return false;
        }
    }

    /**
    * Check whether a king can castle, and add the move(s) if it can
    * @param \CodingBeard\Chess\Board\Square from
    * @param array moves
    */
    public function checkForCastling(const <\CodingBeard\Chess\Board\Square> from, array moves) -> array
    {
        array options, castles = [];
        var move, count, leftRook, rightRook;

        if from->getPiece()->getColour() == Piece::WHITE {
            let options = ["colour": Piece::WHITE, "row": 0];
        }
        else {
            let options = ["colour": Piece::BLACK, "row": 7];
        }

        if !(from->getPiece()->getType() == "King" && from->getPiece()->getColour() == options["colour"] &&
        from->getX() == 4 && from->getY() == options["row"]) {
            return moves;
        }

        let leftRook = this->getSquare(0, options["row"])->getPiece();
        let rightRook = this->getSquare(7, options["row"])->getPiece();

        if leftRook {
            if leftRook->getType() == "Rook" && leftRook->getColour() == options["colour"] {
                let castles[0] = new Move(from, new Square(2, options["row"]));
                for count in [1, 2, 3] {
                    if this->getSquare(count, options["row"])->getPiece() {
                        unset(castles[0]);
                    }
                }
            }
        }
        if rightRook {
            if rightRook->getType() == "Rook" && rightRook->getColour() == options["colour"] {
                let castles[1] = new Move(from, new Square(6, options["row"]));
                for count in [5, 6] {
                    if this->getSquare(count, options["row"])->getPiece() {
                        unset(castles[1]);
                    }
                }
            }
        }

        if count(castles) {
            for move in this->history {
                if move->getFrom()->getX() == from->getX() && move->getFrom()->getY() == from->getY() {
                    return moves;
                }

                if move->getFrom()->getX() == 0 && move->getFrom()->getY() == options["row"] {
                    unset(castles[0]);
                    if !count(castles) {
                        return moves;
                    }
                }

                if move->getFrom()->getX() == 7 && move->getFrom()->getY() == options["row"] {
                    unset(castles[1]);
                    if !count(castles) {
                        return moves;
                    }
                }
            }
            return array_merge(moves, castles);
        }
        return moves;
    }

    /**
    * Check whether a pawn can perform an En Passant attack, and add the move if it can
    * @param \CodingBeard\Chess\Board\Square from
    * @param array moves
    */
    public function checkForEnPassant(const <\CodingBeard\Chess\Board\Square> from, array moves) -> array
    {
        var lastMove;

        let lastMove = end(this->history);
        if !lastMove {
            return moves;
        }

        if lastMove->getFrom()->getPiece()->getColour() == from->getPiece()->getColour() ||
        lastMove->getFrom()->getPiece()->getType() != "Pawn" {
            return moves;
        }

        if lastMove->getTo()->getY() != from->getY() {
            return moves;
        }

        if abs(lastMove->getTo()->getX() - from->getX()) != 1 {
            return moves;
        }

        if from->getPiece()->getColour() == Piece::WHITE {
            let moves[] = new Move(
                from, new Square(lastMove->getFrom()->getX(), lastMove->getTo()->getY() + 1)
            );
        }
        else {
            let moves[] = new Move(
                from, new Square(lastMove->getFrom()->getX(), lastMove->getTo()->getY() - 1)
            );
        }
        return moves;
    }

    /**
    * Populate the possibleMoves array with all the possible moves that can be taken on this board
    * @param
    */
    public function setPossibleMoves(const bool turn = false) -> <\CodingBeard\Chess\Board>
    {
        var column, square, moves;

        let this->possibleMoves = [Piece::WHITE: [], Piece::BLACK: []];

        for column in this->squares {
            for square in column {
                if square->getPiece() {
                    if turn {
                        if square->getPiece()->getColour() != this->getTurn() {
                            continue;
                        }
                    }
                    let moves = this->getMoves(square->getX(), square->getY());
                    if square->getPiece()->getColour() == Piece::WHITE && moves {
                        let this->possibleMoves[Piece::WHITE] = array_merge(this->possibleMoves[Piece::WHITE], moves);
                    }
                    elseif square->getPiece()->getColour() == Piece::BLACK && moves {
                        let this->possibleMoves[Piece::BLACK] = array_merge(this->possibleMoves[Piece::BLACK], moves);
                    }
                }
            }
        }

        return this;
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

        if move->getFrom()->getPiece()->getColour() == Piece::WHITE {
            let this->turn = Piece::BLACK;
        }
        else {
            let this->turn = Piece::WHITE;
        }

        let this->history[] = clone move;
    }

    /**
    * Make a move on the board
    * @param \CodingBeard\Chess\Board\Move move
    */
    public function undoMove(const <\CodingBeard\Chess\Board\Move> move)
    {
        this->setSquare(move->getTo()->getX(), move->getTo()->getY(), move->getTo()->getPiece());
        this->setSquare(move->getFrom()->getX(), move->getFrom()->getY(), move->getFrom()->getPiece());

        array_pop(this->history);

        if move->getDoubleMove() {
            this->undoMove(move->getDoubleMove());
        }

        if move->getFrom()->getPiece()->getColour() == Piece::WHITE {
            let this->turn = Piece::WHITE;
        }
        else {
            let this->turn = Piece::BLACK;
        }
    }

    /**
    * Stringify self
    */
    public function toString() -> string
    {
        var column, square, squares = [];
        for column in this->squares {
            for square in column {
                if square->getPiece() {
                    let squares[square->getX()][square->getY()] = [square->getPiece()->getColour(), square->getPiece()->getType()];
                }
            }
        }
        return json_encode(squares);
    }

    /**
    * Array self
    */
    public function toArray() -> string
    {
        var column, square, squares = [];
        for column in this->squares {
            for square in column {
                if square->getPiece() {
                    let squares[square->getX()][square->getY()] = [square->getPiece()->getColour(), square->getPiece()->getType()];
                }
            }
        }
        return squares;
    }

    /**
    * Clone the squares, history if this board is cloned
    */
    public function __clone()
    {
        var cKey, column, sKey, square, mKey, move;

        for cKey, column in this->squares {
            for sKey, square in column {
                let this->squares[cKey][sKey] = clone square;
            }
        }

        for mKey, move in this->history {
            let this->history[mKey] = clone move;
        }
    }

}