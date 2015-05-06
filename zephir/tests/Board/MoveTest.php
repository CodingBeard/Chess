<?php

/*
 * Move Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\King;
use CodingBeard\Chess\Board\Piece\Knight;
use CodingBeard\Chess\Board\Piece\Pawn;
use CodingBeard\Chess\Board\Piece\Rook;

class MoveTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Board\Move::__construct
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testConstructBare()
    {
        $Move = new Move();
        $this->assertInstanceOf('CodingBeard\Chess\Board\Move', $Move);

        $Move = new Move(new Square(0, 0), new Square(1, 1));

        $this->assertEquals(new Square(0, 0), $Move->getFrom());
        $this->assertEquals(new Square(1, 1), $Move->getTo());
        $this->assertEquals(false, $Move->getAttack());
        $this->assertEquals(false, $Move->getDoubleMove());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Move::__construct
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testConstructFromPiece()
    {
        $Move = new Move(new Square(0, 0, new Pawn(Piece::WHITE)), new Square(1, 1));

        $this->assertEquals(new Square(0, 0, new Pawn(Piece::WHITE)), $Move->getFrom());
        $this->assertEquals(new Square(1, 1), $Move->getTo());
        $this->assertEquals(false, $Move->getAttack());
        $this->assertEquals(false, $Move->getDoubleMove());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Move::__construct
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testConstructAttack()
    {
        $Move = new Move(new Square(0, 0, new Pawn(Piece::WHITE)), new Square(1, 1, new Knight(Piece::BLACK)));

        $this->assertEquals(new Square(0, 0, new Pawn(Piece::WHITE)), $Move->getFrom());
        $this->assertEquals(new Square(1, 1, new Knight(Piece::BLACK)), $Move->getTo());
        $this->assertEquals(true, $Move->getAttack());
        $this->assertEquals(false, $Move->getDoubleMove());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Move::__construct
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testConstructCastling()
    {
        $Move = new Move(new Square(4, 0, new King(Piece::WHITE)), new Square(2, 0));

        $this->assertEquals(new Move(
            new Square(0, 0, new Rook(Piece::WHITE)), new Square(3, 0)
        ), $Move->getDoubleMove());

        $Move = new Move(new Square(4, 0, new King(Piece::WHITE)), new Square(6, 0));

        $this->assertEquals(new Move(
            new Square(7, 0, new Rook(Piece::WHITE)), new Square(5, 0)
        ), $Move->getDoubleMove());

        $Move = new Move(new Square(4, 7, new King(Piece::BLACK)), new Square(2, 7));

        $this->assertEquals(new Move(
            new Square(0, 7, new Rook(Piece::BLACK)), new Square(3, 7)
        ), $Move->getDoubleMove());

        $Move = new Move(new Square(4, 7, new King(Piece::BLACK)), new Square(6, 7));

        $this->assertEquals(new Move(
            new Square(7, 7, new Rook(Piece::BLACK)), new Square(5, 7)
        ), $Move->getDoubleMove());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Move::__construct
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testConstructPassant()
    {
        $Move = new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(0, 2));

        $this->assertEquals(new Move(
            new Square(0, 3, new Pawn(Piece::WHITE)), new Square(0, 2)
        ), $Move->getDoubleMove());


        $Move = new Move(new Square(1, 3, new Pawn(Piece::BLACK)), new Square(2, 2));

        $this->assertEquals(new Move(
            new Square(2, 3, new Pawn(Piece::WHITE)), new Square(2, 2)
        ), $Move->getDoubleMove());


        $Move = new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(0, 5));

        $this->assertEquals(new Move(
            new Square(0, 4, new Pawn(Piece::BLACK)), new Square(0, 5)
        ), $Move->getDoubleMove());


        $Move = new Move(new Square(1, 4, new Pawn(Piece::WHITE)), new Square(2, 5));

        $this->assertEquals(new Move(
            new Square(2, 4, new Pawn(Piece::BLACK)), new Square(2, 5)
        ), $Move->getDoubleMove());
    }

}
