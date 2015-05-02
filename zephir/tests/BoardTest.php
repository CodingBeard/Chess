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
use CodingBeard\Chess\Board\Move;
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

        $this->assertEquals(new Square(0, 0, new Rook(Piece::WHITE)), $board->getSquare(0, 0));
        $this->assertEquals(new Square(2, 5), $board->getSquare(2, 5));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::setSquare
     * @uses              \CodingBeard\Chess\Board
     */
    public function testSetSquare()
    {
        $board = new Board();
        $board->setSquare(3, 4, new Queen(Piece::WHITE));

        $this->assertEquals(new Square(3, 4, new Queen(Piece::WHITE)), $board->getSquare(3, 4));

        $board->setSquare(3, 4);

        $this->assertEquals(new Square(3, 4), $board->getSquare(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::makeMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testMakeMove()
    {
        $board = new Board();
        $move = new Move(new Square(3, 0, new Queen(Piece::WHITE)), new Square(4, 4));
        $board->makeMove($move);

        $this->assertEquals(new Square(3, 0), $board->getSquare(3, 0));
        $this->assertEquals(new Square(4, 4, new Queen(Piece::WHITE)), $board->getSquare(4, 4));

    }

    /**
     * @covers            \CodingBeard\Chess\Board::printBoard
     * @uses              \CodingBeard\Chess\Board
     */
    public function testPrintBoard()
    {
        $board = new Board();
        $this->assertEquals(
              "   | 0  | 1  | 2  | 3  | 4  | 5  | 6  | 7  |   " . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "7  | bR | bK | bB | bQ | bK | bB | bK | bR |   7" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "6  | bP | bP | bP | bP | bP | bP | bP | bP |   6" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "5  |    |    |    |    |    |    |    |    |   5" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "4  |    |    |    |    |    |    |    |    |   4" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "3  |    |    |    |    |    |    |    |    |   3" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "2  |    |    |    |    |    |    |    |    |   2" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "1  | wP | wP | wP | wP | wP | wP | wP | wP |   1" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "0  | wR | wK | wB | wQ | wK | wB | wK | wR |   0" . PHP_EOL
            . "-----------------------------------------------" . PHP_EOL
            . "   | 0  | 1  | 2  | 3  | 4  | 5  | 6  | 7  |   " . PHP_EOL, $board->printBoard());
    }

}
