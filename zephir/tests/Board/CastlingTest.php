<?php

/*
 * Castling Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Board;
use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\King;
use CodingBeard\Chess\Pieces\Rook;

class CastlingTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::makeMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testMakeMoveCastling()
    {
        $board = new Board(true);
        $board->setSquare(0, 0, new Rook(Piece::WHITE));
        $board->setSquare(4, 0, new King(Piece::WHITE));
        $move = new Move(new Square(4, 0, new King(Piece::WHITE)), new Square(2, 0));
        $board->makeMove($move);

        $this->assertEquals(new Square(0, 0), $board->getSquare(0, 0));
        $this->assertEquals(new Square(3, 0, new Rook(Piece::WHITE)), $board->getSquare(3, 0));
        $this->assertEquals(new Square(4, 0), $board->getSquare(4, 0));
        $this->assertEquals(new Square(2, 0, new King(Piece::WHITE)), $board->getSquare(2, 0));


        $board = new Board(true);
        $board->setSquare(7, 0, new Rook(Piece::WHITE));
        $board->setSquare(4, 0, new King(Piece::WHITE));
        $move = new Move(new Square(4, 0, new King(Piece::WHITE)), new Square(6, 0));
        $board->makeMove($move);

        $this->assertEquals(new Square(7, 0), $board->getSquare(7, 0));
        $this->assertEquals(new Square(5, 0, new Rook(Piece::WHITE)), $board->getSquare(5, 0));
        $this->assertEquals(new Square(4, 0), $board->getSquare(4, 0));
        $this->assertEquals(new Square(6, 0, new King(Piece::WHITE)), $board->getSquare(6, 0));


        $board = new Board(true);
        $board->setSquare(0, 7, new Rook(Piece::BLACK));
        $board->setSquare(4, 7, new King(Piece::BLACK));
        $move = new Move(new Square(4, 7, new King(Piece::BLACK)), new Square(2, 7));
        $board->makeMove($move);

        $this->assertEquals(new Square(0, 7), $board->getSquare(0, 7));
        $this->assertEquals(new Square(3, 7, new Rook(Piece::BLACK)), $board->getSquare(3, 7));
        $this->assertEquals(new Square(4, 7), $board->getSquare(4, 7));
        $this->assertEquals(new Square(2, 7, new King(Piece::BLACK)), $board->getSquare(2, 7));


        $board = new Board(true);
        $board->setSquare(7, 7, new Rook(Piece::BLACK));
        $board->setSquare(4, 7, new King(Piece::BLACK));
        $move = new Move(new Square(4, 7, new King(Piece::BLACK)), new Square(6, 7));
        $board->makeMove($move);

        $this->assertEquals(new Square(7, 7), $board->getSquare(7, 7));
        $this->assertEquals(new Square(5, 7, new Rook(Piece::BLACK)), $board->getSquare(5, 7));
        $this->assertEquals(new Square(4, 7), $board->getSquare(4, 7));
        $this->assertEquals(new Square(6, 7, new King(Piece::BLACK)), $board->getSquare(6, 7));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::makeMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testUndoMoveCastling()
    {
        $board = new Board(true);
        $board->setSquare(3, 0, new Rook(Piece::WHITE));
        $board->setSquare(2, 0, new King(Piece::WHITE));
        $move = new Move(new Square(4, 0, new King(Piece::WHITE)), new Square(2, 0));
        $board->undoMove($move);

        $this->assertEquals(new Square(3, 0), $board->getSquare(3, 0));
        $this->assertEquals(new Square(0, 0, new Rook(Piece::WHITE)), $board->getSquare(0, 0));
        $this->assertEquals(new Square(2, 0), $board->getSquare(2, 0));
        $this->assertEquals(new Square(4, 0, new King(Piece::WHITE)), $board->getSquare(4, 0));


        $board = new Board(true);
        $board->setSquare(5, 0, new Rook(Piece::WHITE));
        $board->setSquare(6, 0, new King(Piece::WHITE));
        $move = new Move(new Square(4, 0, new King(Piece::WHITE)), new Square(6, 0));
        $board->undoMove($move);

        $this->assertEquals(new Square(5, 0), $board->getSquare(5, 0));
        $this->assertEquals(new Square(7, 0, new Rook(Piece::WHITE)), $board->getSquare(7, 0));
        $this->assertEquals(new Square(6, 0), $board->getSquare(6, 0));
        $this->assertEquals(new Square(4, 0, new King(Piece::WHITE)), $board->getSquare(4, 0));


        $board = new Board(true);
        $board->setSquare(3, 7, new Rook(Piece::BLACK));
        $board->setSquare(2, 7, new King(Piece::BLACK));
        $move = new Move(new Square(4, 7, new King(Piece::BLACK)), new Square(2, 7));
        $board->undoMove($move);

        $this->assertEquals(new Square(3, 7), $board->getSquare(3, 7));
        $this->assertEquals(new Square(0, 7, new Rook(Piece::BLACK)), $board->getSquare(0, 7));
        $this->assertEquals(new Square(2, 7), $board->getSquare(2, 7));
        $this->assertEquals(new Square(4, 7, new King(Piece::BLACK)), $board->getSquare(4, 7));


        $board = new Board(true);
        $board->setSquare(5, 7, new Rook(Piece::BLACK));
        $board->setSquare(6, 7, new King(Piece::BLACK));
        $move = new Move(new Square(4, 7, new King(Piece::BLACK)), new Square(6, 7));
        $board->undoMove($move);

        $this->assertEquals(new Square(5, 7), $board->getSquare(5, 7));
        $this->assertEquals(new Square(7, 7, new Rook(Piece::BLACK)), $board->getSquare(7, 7));
        $this->assertEquals(new Square(6, 7), $board->getSquare(6, 7));
        $this->assertEquals(new Square(4, 7, new King(Piece::BLACK)), $board->getSquare(4, 7));
    }
}
