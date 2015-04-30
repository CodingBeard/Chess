<?php

/*
 * Board Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Board;
use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\Bishop;
use CodingBeard\Chess\Pieces\King;
use CodingBeard\Chess\Pieces\Knight;
use CodingBeard\Chess\Pieces\Pawn;
use CodingBeard\Chess\Pieces\Queen;
use CodingBeard\Chess\Pieces\Rook;

class BoardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Board::__construct
     * @uses              \CodingBeard\Chess\Board
     */
    public function testConstruct()
    {
        $board = new Board();

        $this->assertInstanceOf('CodingBeard\Chess\Board', $board);


        $this->assertEquals([
            [
                new Square(0, 0, new Rook(Piece::WHITE)),
                new Square(0, 1, new Pawn(Piece::WHITE)),
                new Square(0, 2),
                new Square(0, 3),
                new Square(0, 4),
                new Square(0, 5),
                new Square(0, 6, new Pawn(Piece::BLACK)),
                new Square(0, 7, new Rook(Piece::BLACK)),
            ],
            [
                new Square(1, 0, new Knight(Piece::WHITE)),
                new Square(1, 1, new Pawn(Piece::WHITE)),
                new Square(1, 2),
                new Square(1, 3),
                new Square(1, 4),
                new Square(1, 5),
                new Square(1, 6, new Pawn(Piece::BLACK)),
                new Square(1, 7, new Knight(Piece::BLACK)),
            ],
            [
                new Square(2, 0, new Bishop(Piece::WHITE)),
                new Square(2, 1, new Pawn(Piece::WHITE)),
                new Square(2, 2),
                new Square(2, 3),
                new Square(2, 4),
                new Square(2, 5),
                new Square(2, 6, new Pawn(Piece::BLACK)),
                new Square(2, 7, new Bishop(Piece::BLACK)),
            ],
            [
                new Square(3, 0, new Queen(Piece::WHITE)),
                new Square(3, 1, new Pawn(Piece::WHITE)),
                new Square(3, 2),
                new Square(3, 3),
                new Square(3, 4),
                new Square(3, 5),
                new Square(3, 6, new Pawn(Piece::BLACK)),
                new Square(3, 7, new Queen(Piece::BLACK)),
            ],
            [
                new Square(4, 0, new King(Piece::WHITE)),
                new Square(4, 1, new Pawn(Piece::WHITE)),
                new Square(4, 2),
                new Square(4, 3),
                new Square(4, 4),
                new Square(4, 5),
                new Square(4, 6, new Pawn(Piece::BLACK)),
                new Square(4, 7, new King(Piece::BLACK)),
            ],
            [
                new Square(5, 0, new Bishop(Piece::WHITE)),
                new Square(5, 1, new Pawn(Piece::WHITE)),
                new Square(5, 2),
                new Square(5, 3),
                new Square(5, 4),
                new Square(5, 5),
                new Square(5, 6, new Pawn(Piece::BLACK)),
                new Square(5, 7, new Bishop(Piece::BLACK)),
            ],
            [
                new Square(6, 0, new Knight(Piece::WHITE)),
                new Square(6, 1, new Pawn(Piece::WHITE)),
                new Square(6, 2),
                new Square(6, 3),
                new Square(6, 4),
                new Square(6, 5),
                new Square(6, 6, new Pawn(Piece::BLACK)),
                new Square(6, 7, new Knight(Piece::BLACK)),
            ],
            [
                new Square(7, 0, new Rook(Piece::WHITE)),
                new Square(7, 1, new Pawn(Piece::WHITE)),
                new Square(7, 2),
                new Square(7, 3),
                new Square(7, 4),
                new Square(7, 5),
                new Square(7, 6, new Pawn(Piece::BLACK)),
                new Square(7, 7, new Rook(Piece::BLACK)),
            ],
        ], $board->getSquares());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getSquare
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetSquare()
    {
        $board = new Board();

        $this->assertEquals(new Square(0, 0, new Rook(Piece::WHITE)), $board->getSquare());

        $board->setLocation([2, 5]);

        $this->assertEquals(new Square(2, 5), $board->getSquare());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::setSquare
     * @uses              \CodingBeard\Chess\Board
     */
    public function testSetSquare()
    {
        $board = new Board();
        $board->setSquare(3, 4, new Queen(Piece::WHITE));
        $board->setLocation([3, 4]);

        $this->assertEquals(new Square(3, 4, new Queen(Piece::WHITE)), $board->getSquare());

        $board->setSquare(3, 4);

        $this->assertEquals(new Square(3, 4, false), $board->getSquare());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::startMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testStartMove()
    {
        $board = new Board();

        $board->startMove();

        $this->assertInstanceOf('CodingBeard\Chess\Board\Move', $board->getMove());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::north
     * @uses              \CodingBeard\Chess\Board
     */
    public function testNorth()
    {
        $board = new Board();
        $board->north();

        $this->assertEquals([0, 1], $board->getLocation());

        $board->north()->north();

        $this->assertEquals([0, 3], $board->getLocation());

        $board->north()->north()->north()->north()->north()->north();

        $this->assertEquals([0, 7], $board->getLocation());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::northeast
     * @uses              \CodingBeard\Chess\Board
     */
    public function testNortheast()
    {
        $board = new Board();
        $board->northeast();

        $this->assertEquals([1, 1], $board->getLocation());

        $board->northeast()->northeast();

        $this->assertEquals([3, 3], $board->getLocation());

        $board->northeast()->northeast()->northeast()->northeast()->northeast()->northeast();

        $this->assertEquals([7, 7], $board->getLocation());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::east
     * @uses              \CodingBeard\Chess\Board
     */
    public function testEast()
    {
        $board = new Board();
        $board->east();

        $this->assertEquals([1, 0], $board->getLocation());

        $board->east()->east();

        $this->assertEquals([3, 0], $board->getLocation());

        $board->east()->east()->east()->east()->east()->east();

        $this->assertEquals([7, 0], $board->getLocation());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::southeast
     * @uses              \CodingBeard\Chess\Board
     */
    public function testSoutheast()
    {
        $board = new Board();
        $board->setLocation([0, 7]);
        $board->southeast();

        $this->assertEquals([1, 6], $board->getLocation());

        $board->southeast()->southeast();

        $this->assertEquals([3, 4], $board->getLocation());

        $board->southeast()->southeast()->southeast()->southeast()->southeast()->southeast();

        $this->assertEquals([7, 0], $board->getLocation());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::south
     * @uses              \CodingBeard\Chess\Board
     */
    public function testSouth()
    {
        $board = new Board();
        $board->setLocation([0, 7]);
        $board->south();

        $this->assertEquals([0, 6], $board->getLocation());

        $board->south()->south();

        $this->assertEquals([0, 4], $board->getLocation());

        $board->south()->south()->south()->south()->south()->south();

        $this->assertEquals([0, 0], $board->getLocation());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::southwest
     * @uses              \CodingBeard\Chess\Board
     */
    public function testSouthwest()
    {
        $board = new Board();
        $board->setLocation([7, 7]);
        $board->southwest();

        $this->assertEquals([6, 6], $board->getLocation());

        $board->southwest()->southwest();

        $this->assertEquals([4, 4], $board->getLocation());

        $board->southwest()->southwest()->southwest()->southwest()->southwest()->southwest();

        $this->assertEquals([0, 0], $board->getLocation());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::west
     * @uses              \CodingBeard\Chess\Board
     */
    public function testWest()
    {
        $board = new Board();
        $board->setLocation([7, 0]);
        $board->west();

        $this->assertEquals([6, 0], $board->getLocation());

        $board->west()->west();

        $this->assertEquals([4, 0], $board->getLocation());

        $board->west()->west()->west()->west()->west()->west();

        $this->assertEquals([0, 0], $board->getLocation());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::northwest
     * @uses              \CodingBeard\Chess\Board
     */
    public function testNorthwest()
    {
        $board = new Board();
        $board->setLocation([7, 0]);
        $board->northwest();

        $this->assertEquals([6, 1], $board->getLocation());

        $board->northwest()->northwest();

        $this->assertEquals([4, 3], $board->getLocation());

        $board->northwest()->northwest()->northwest()->northwest()->northwest()->northwest();

        $this->assertEquals([0, 7], $board->getLocation());
    }

}
