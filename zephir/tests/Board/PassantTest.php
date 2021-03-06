<?php

/*
 * Passant Test
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
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Pawn;

class PassantTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::makeMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testMakeMovePassant()
    {
        $board = new Board();
        $board->setSquare(0, 3, new Pawn(Piece::WHITE));
        $board->setSquare(1, 3, new Pawn(Piece::BLACK));
        $move = new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(0, 2));
        $board->makeMove($move);

        $this->assertEquals(new Square(1, 3), $board->getSquare(1, 3));
        $this->assertEquals(new Square(0, 2, new Pawn(Piece::BLACK)), $board->getSquare(0, 2));
        $this->assertEquals(new Square(0, 3), $board->getSquare(0, 3));


        $board = new Board();
        $board->setSquare(2, 3, new Pawn(Piece::WHITE));
        $board->setSquare(1, 3, new Pawn(Piece::BLACK));
        $move = new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(2, 2));
        $board->makeMove($move);

        $this->assertEquals(new Square(1, 3), $board->getSquare(1, 3));
        $this->assertEquals(new Square(2, 2, new Pawn(Piece::BLACK)), $board->getSquare(2, 2));
        $this->assertEquals(new Square(2, 3), $board->getSquare(2, 3));


        $board = new Board();
        $board->setSquare(0, 4, new Pawn(Piece::BLACK));
        $board->setSquare(1, 4, new Pawn(Piece::WHITE));
        $move = new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(0, 5));
        $board->makeMove($move);

        $this->assertEquals(new Square(1, 4), $board->getSquare(1, 4));
        $this->assertEquals(new Square(0, 5, new Pawn(Piece::WHITE)), $board->getSquare(0, 5));
        $this->assertEquals(new Square(0, 4), $board->getSquare(0, 4));


        $board = new Board();
        $board->setSquare(2, 4, new Pawn(Piece::BLACK));
        $board->setSquare(1, 4, new Pawn(Piece::WHITE));
        $move = new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(2, 5));
        $board->makeMove($move);

        $this->assertEquals(new Square(1, 4), $board->getSquare(1, 4));
        $this->assertEquals(new Square(2, 5, new Pawn(Piece::WHITE)), $board->getSquare(2, 5));
        $this->assertEquals(new Square(2, 4), $board->getSquare(2, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::makeMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testUndoMovePassant()
    {
        $board = new Board();
        $board->setSquare(0, 2, new Pawn(Piece::BLACK));
        $move = new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(0, 2));
        $board->undoMove($move);

        $this->assertEquals(new Square(0, 2), $board->getSquare(0, 2));
        $this->assertEquals(new Square(1, 3, new Pawn(Piece::BLACK)), $board->getSquare(1, 3));
        $this->assertEquals(new Square(0, 3, new Pawn(Piece::WHITE)), $board->getSquare(0, 3));


        $board = new Board();
        $board->setSquare(2, 2, new Pawn(Piece::BLACK));
        $move = new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(2, 2));
        $board->undoMove($move);

        $this->assertEquals(new Square(2, 2), $board->getSquare(2, 2));
        $this->assertEquals(new Square(1, 3, new Pawn(Piece::BLACK)), $board->getSquare(1, 3));
        $this->assertEquals(new Square(2, 3, new Pawn(Piece::WHITE)), $board->getSquare(2, 3));


        $board = new Board();
        $board->setSquare(0, 5, new Pawn(Piece::WHITE));
        $move = new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(0, 5));
        $board->undoMove($move);

        $this->assertEquals(new Square(0, 5), $board->getSquare(0, 5));
        $this->assertEquals(new Square(1, 4, new Pawn(Piece::WHITE)), $board->getSquare(1, 4));
        $this->assertEquals(new Square(0, 4, new Pawn(Piece::BLACK)), $board->getSquare(0, 4));


        $board = new Board();
        $board->setSquare(2, 5, new Pawn(Piece::WHITE));
        $move = new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(2, 5));
        $board->undoMove($move);

        $this->assertEquals(new Square(2, 5), $board->getSquare(2, 5));
        $this->assertEquals(new Square(1, 4, new Pawn(Piece::WHITE)), $board->getSquare(1, 4));
        $this->assertEquals(new Square(2, 4, new Pawn(Piece::BLACK)), $board->getSquare(2, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @covers            \CodingBeard\Chess\Board::checkForEnPassant
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesPassant()
    {
        $board = new Board();
        $board->setSquare(0, 3, new Pawn(Piece::WHITE));
        $board->setSquare(1, 3, new Pawn(Piece::BLACK));

        $this->assertEquals([
            new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(1, 2)),
        ], $board->getMoves(1, 3));

        $board->setHistory([new Move(new Square(0, 1, new Pawn(Piece::WHITE)), new Square(0, 3))]);

        $this->assertEquals([
            new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(1, 2)),
            new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(0, 2)),
        ], $board->getMoves(1, 3));


        $board = new Board();
        $board->setSquare(2, 3, new Pawn(Piece::WHITE));
        $board->setSquare(1, 3, new Pawn(Piece::BLACK));

        $board->setHistory([new Move(new Square(2, 1, new Pawn(Piece::WHITE)), new Square(2, 3))]);

        $this->assertEquals([
            new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(1, 2)),
            new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(2, 2)),
        ], $board->getMoves(1, 3));


        $board = new Board();
        $board->setSquare(0, 4, new Pawn(Piece::BLACK));
        $board->setSquare(1, 4, new Pawn(Piece::WHITE));

        $board->setHistory([new Move(new Square(0, 6, new Pawn(Piece::BLACK)), new Square(0, 4))]);

        $this->assertEquals([
            new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(1, 5)),
            new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(0, 5)),
        ], $board->getMoves(1, 4));


        $board = new Board();
        $board->setSquare(2, 4, new Pawn(Piece::BLACK));
        $board->setSquare(1, 4, new Pawn(Piece::WHITE));

        $board->setHistory([new Move(new Square(2, 6, new Pawn(Piece::BLACK)), new Square(2, 4))]);

        $this->assertEquals([
            new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(1, 5)),
            new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(2, 5)),
        ], $board->getMoves(1, 4));

    }
}
