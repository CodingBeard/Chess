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
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Queen;

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
                new Square(0, 0),
                new Square(0, 1),
                new Square(0, 2),
                new Square(0, 3),
                new Square(0, 4),
                new Square(0, 5),
                new Square(0, 6),
                new Square(0, 7),
            ],
            [
                new Square(1, 0),
                new Square(1, 1),
                new Square(1, 2),
                new Square(1, 3),
                new Square(1, 4),
                new Square(1, 5),
                new Square(1, 6),
                new Square(1, 7),
            ],
            [
                new Square(2, 0),
                new Square(2, 1),
                new Square(2, 2),
                new Square(2, 3),
                new Square(2, 4),
                new Square(2, 5),
                new Square(2, 6),
                new Square(2, 7),
            ],
            [
                new Square(3, 0),
                new Square(3, 1),
                new Square(3, 2),
                new Square(3, 3),
                new Square(3, 4),
                new Square(3, 5),
                new Square(3, 6),
                new Square(3, 7),
            ],
            [
                new Square(4, 0),
                new Square(4, 1),
                new Square(4, 2),
                new Square(4, 3),
                new Square(4, 4),
                new Square(4, 5),
                new Square(4, 6),
                new Square(4, 7),
            ],
            [
                new Square(5, 0),
                new Square(5, 1),
                new Square(5, 2),
                new Square(5, 3),
                new Square(5, 4),
                new Square(5, 5),
                new Square(5, 6),
                new Square(5, 7),
            ],
            [
                new Square(6, 0),
                new Square(6, 1),
                new Square(6, 2),
                new Square(6, 3),
                new Square(6, 4),
                new Square(6, 5),
                new Square(6, 6),
                new Square(6, 7),
            ],
            [
                new Square(7, 0),
                new Square(7, 1),
                new Square(7, 2),
                new Square(7, 3),
                new Square(7, 4),
                new Square(7, 5),
                new Square(7, 6),
                new Square(7, 7),
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

        $this->assertEquals(Piece::WHITE, $board->getTurn());

        $board->setSquare(3, 0, new Queen(Piece::WHITE));
        $move = new Move(new Square(3, 0, new Queen(Piece::WHITE)), new Square(4, 4));
        $board->makeMove($move);

        $this->assertEquals(Piece::BLACK, $board->getTurn());
        $this->assertEquals(new Square(3, 0), $board->getSquare(3, 0));
        $this->assertEquals(new Square(4, 4, new Queen(Piece::WHITE)), $board->getSquare(4, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::undoMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testUndoMove()
    {
        $board = new Board();

        $this->assertEquals(Piece::WHITE, $board->getTurn());

        $board->setSquare(3, 0, new Queen(Piece::WHITE));
        $move = new Move(new Square(3, 0, new Queen(Piece::WHITE)), new Square(4, 4));
        $board->makeMove($move);

        $this->assertEquals(Piece::BLACK, $board->getTurn());

        $board->undoMove($move);

        $this->assertEquals(Piece::WHITE, $board->getTurn());
        $this->assertEquals(new Square(3, 0, new Queen(Piece::WHITE)), $board->getSquare(3, 0));
        $this->assertEquals(new Square(4, 4), $board->getSquare(4, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::makeMove
     * @covers            \CodingBeard\Chess\Board::undoMove
     * @uses              \CodingBeard\Chess\Board
     */
    public function testHistory()
    {
        $board = new Board();
        $board->setSquare(3, 0, new Queen(Piece::WHITE));
        $firstMove = new Move(new Square(3, 0, new Queen(Piece::WHITE)), new Square(4, 4));
        $board->makeMove($firstMove);

        $this->assertEquals([$firstMove], $board->getHistory());

        $secondMove = new Move(new Square(4, 4, new Queen(Piece::WHITE)), new Square(4, 5));
        $board->makeMove($secondMove);

        $this->assertEquals([$firstMove, $secondMove], $board->getHistory());

        $board->undoMove($secondMove);

        $this->assertEquals([$firstMove], $board->getHistory());

        $board->undoMove($firstMove);

        $this->assertEquals([], $board->getHistory());
    }

    /**
     * @covers            \CodingBeard\Chess\Board::toString
     * @uses              \CodingBeard\Chess\Board
     */
    public function testPrintBoard()
    {
        $board = new Board();
        $board->setDefaults();
        $this->assertEquals(
            '[{"0":[0,"Rook"],"1":[0,"Pawn"],"6":[1,"Pawn"],"7":[1,"Rook"]},{"0":[0,"Knight"],'
            . '"1":[0,"Pawn"],"6":[1,"Pawn"],"7":[1,"Knight"]},{"0":[0,"Bishop"],"1":[0,"Pawn"],"6":[1,"Pawn"],"7":[1,'
            . '"Bishop"]},{"0":[0,"Queen"],"1":[0,"Pawn"],"6":[1,"Pawn"],"7":[1,"Queen"]},{"0":[0,"King"],"1":[0,"Pawn"],'
            . '"6":[1,"Pawn"],"7":[1,"King"]},{"0":[0,"Bishop"],"1":[0,"Pawn"],"6":[1,"Pawn"],"7":[1,"Bishop"]},{"0":[0,'
            . '"Knight"],"1":[0,"Pawn"],"6":[1,"Pawn"],"7":[1,"Knight"]},{"0":[0,"Rook"],"1":[0,"Pawn"],"6":[1,"Pawn"],'
            . '"7":[1,"Rook"]}]', $board->toString());
    }

}
