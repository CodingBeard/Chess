<?php

/*
 * Queen Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Board;
use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Pawn;
use CodingBeard\Chess\Board\Piece\Queen;

class GetMovesQueenTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesNoObstacles()
    {
        $board = new Board();
        $board->setSquare(3, 4, new Queen(Piece::WHITE));
        $from = new Square(3, 4, new Queen(Piece::WHITE));

        $this->assertEquals([
            /* N */
            new Move($from, new Square(3, 5)), new Move($from, new Square(3, 6)), new Move($from, new Square(3, 7)),
            /* NE */
            new Move($from, new Square(4, 5)), new Move($from, new Square(5, 6)), new Move($from, new Square(6, 7)),
            /* E */
            new Move($from, new Square(4, 4)), new Move($from, new Square(5, 4)),
            new Move($from, new Square(6, 4)), new Move($from, new Square(7, 4)),
            /* SE */
            new Move($from, new Square(4, 3)), new Move($from, new Square(5, 2)),
            new Move($from, new Square(6, 1)), new Move($from, new Square(7, 0)),
            /* S */
            new Move($from, new Square(3, 3)), new Move($from, new Square(3, 2)),
            new Move($from, new Square(3, 1)), new Move($from, new Square(3, 0)),
            /* SW */
            new Move($from, new Square(2, 3)), new Move($from, new Square(1, 2)), new Move($from, new Square(0, 1)),
            /* W */
            new Move($from, new Square(2, 4)), new Move($from, new Square(1, 4)), new Move($from, new Square(0, 4)),
            /* NW */
            new Move($from, new Square(2, 5)), new Move($from, new Square(1, 6)), new Move($from, new Square(0, 7)),
        ], $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesNoPiece()
    {
        $board = new Board();

        $this->assertEquals(false, $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesWhite()
    {
        $board = new Board();
        $board->setSquare(3, 4, new Queen(Piece::WHITE));
        $from = new Square(3, 4, new Queen(Piece::WHITE));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 5, new Pawn(Piece::WHITE)); //N
        $board->setSquare(5, 6, new Pawn(Piece::BLACK)); //NE
        $board->setSquare(6, 4, new Pawn(Piece::WHITE)); //E
        $board->setSquare(7, 0, new Pawn(Piece::BLACK)); //SE
        $board->setSquare(3, 1, new Pawn(Piece::WHITE)); //S
        $board->setSquare(1, 2, new Pawn(Piece::BLACK)); //SW
        $board->setSquare(2, 4, new Pawn(Piece::WHITE)); //W
        $board->setSquare(1, 6, new Pawn(Piece::BLACK)); //NE
        $this->assertEquals([
            /* N */

            /* NE */
            new Move($from, new Square(4, 5)), new Move($from, new Square(5, 6, new Pawn(Piece::BLACK))),
            /* E */
            new Move($from, new Square(4, 4)), new Move($from, new Square(5, 4)),
            /* SE */
            new Move($from, new Square(4, 3)), new Move($from, new Square(5, 2)),
            new Move($from, new Square(6, 1)), new Move($from, new Square(7, 0, new Pawn(Piece::BLACK))),
            /* S */
            new Move($from, new Square(3, 3)), new Move($from, new Square(3, 2)),
            /* SW */
            new Move($from, new Square(2, 3)), new Move($from, new Square(1, 2, new Pawn(Piece::BLACK))),
            /* W */

            /* NW */
            new Move($from, new Square(2, 5)), new Move($from, new Square(1, 6, new Pawn(Piece::BLACK))),
        ], $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesBlack()
    {
        $board = new Board();
        $board->setSquare(3, 4, new Queen(Piece::BLACK));
        $from = new Square(3, 4, new Queen(Piece::BLACK));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 5, new Pawn(Piece::WHITE)); //N
        $board->setSquare(5, 6, new Pawn(Piece::BLACK)); //NE
        $board->setSquare(6, 4, new Pawn(Piece::WHITE)); //E
        $board->setSquare(7, 0, new Pawn(Piece::BLACK)); //SE
        $board->setSquare(3, 1, new Pawn(Piece::WHITE)); //S
        $board->setSquare(1, 2, new Pawn(Piece::BLACK)); //SW
        $board->setSquare(2, 4, new Pawn(Piece::WHITE)); //W
        $board->setSquare(1, 6, new Pawn(Piece::BLACK)); //NE
        $this->assertEquals([
            /* N */
            new Move($from, new Square(3, 5, new Pawn(Piece::WHITE))),
            /* NE */
            new Move($from, new Square(4, 5)),
            /* E */
            new Move($from, new Square(4, 4)), new Move($from, new Square(5, 4)),
            new Move($from, new Square(6, 4, new Pawn(Piece::WHITE))),
            /* SE */
            new Move($from, new Square(4, 3)), new Move($from, new Square(5, 2)),
            new Move($from, new Square(6, 1)),
            /* S */
            new Move($from, new Square(3, 3)), new Move($from, new Square(3, 2)),
            new Move($from, new Square(3, 1, new Pawn(Piece::WHITE))),
            /* SW */
            new Move($from, new Square(2, 3)),
            /* W */
            new Move($from, new Square(2, 4, new Pawn(Piece::WHITE))),
            /* NW */
            new Move($from, new Square(2, 5)),
        ], $board->getMoves(3, 4));
    }
}
