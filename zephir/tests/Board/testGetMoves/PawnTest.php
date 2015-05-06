<?php

/*
 * Pawn Test
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

class GetMovesPawnTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesNoObstacles()
    {
        $board = new Board();
        $board->setSquare(3, 1, new Pawn(Piece::WHITE));
        $from = new Square(3, 1, new Pawn(Piece::WHITE));

        $this->assertEquals([
            /* N */
            new Move($from, new Square(3, 2)),
            /* NN */
            new Move($from, new Square(3, 3)),
            /* NE */
            /* NW */
        ], $board->getMoves(3, 1));
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
        $board->setSquare(3, 1, new Pawn(Piece::WHITE));
        $from = new Square(3, 1, new Pawn(Piece::WHITE));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 2, new Pawn(Piece::WHITE)); //N
        $board->setSquare(4, 2, new Pawn(Piece::BLACK)); //NE
        $board->setSquare(2, 2, new Pawn(Piece::WHITE)); //NW
        $this->assertEquals([
            /* N */
            /* NN */
            /* NE */
            new Move($from, new Square(4, 2, new Pawn(Piece::BLACK))),
            /* NW */
        ], $board->getMoves(3, 1));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesBlack()
    {
        $board = new Board();
        $board->setSquare(3, 6, new Pawn(Piece::BLACK));
        $from = new Square(3, 6, new Pawn(Piece::BLACK));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 5, new Pawn(Piece::WHITE)); //S
        $board->setSquare(4, 5, new Pawn(Piece::BLACK)); //SE
        $board->setSquare(2, 5, new Pawn(Piece::WHITE)); //SW

        $this->assertEquals([
            /* S */
            /* SS */
            /* SE */
            /* SW */
            new Move($from, new Square(2, 5, new Pawn(Piece::WHITE))),
        ], $board->getMoves(3, 6));
    }

}
