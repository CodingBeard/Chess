<?php

/*
 * Bishop Test
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
use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\Pawn;
use CodingBeard\Chess\Pieces\Bishop;

class GetMovesBishopTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesNoObstacles()
    {
        $board = new Board(true);
        $board->setSquare(3, 4, new Bishop(Piece::WHITE));
        $from = new Square(3, 4, new Bishop(Piece::WHITE));

        $this->assertEquals([
            /* NE */
            new Move($from, new Square(4, 5)), new Move($from, new Square(5, 6)), new Move($from, new Square(6, 7)),
            /* SE */
            new Move($from, new Square(4, 3)), new Move($from, new Square(5, 2)),
            new Move($from, new Square(6, 1)), new Move($from, new Square(7, 0)),
            /* SW */
            new Move($from, new Square(2, 3)), new Move($from, new Square(1, 2)), new Move($from, new Square(0, 1)),
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
        $board = new Board(true);

        $this->assertEquals(false, $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesWhite()
    {
        $board = new Board(true);
        $board->setSquare(3, 4, new Bishop(Piece::WHITE));
        $from = new Square(3, 4, new Bishop(Piece::WHITE));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(5, 6, new Pawn(Piece::BLACK)); //NE
        $board->setSquare(7, 0, new Pawn(Piece::WHITE)); //SE
        $board->setSquare(1, 2, new Pawn(Piece::BLACK)); //SW
        $board->setSquare(1, 6, new Pawn(Piece::WHITE)); //NE
        $this->assertEquals([
            /* NE */
            new Move($from, new Square(4, 5)), new Move($from, new Square(5, 6, new Pawn(Piece::BLACK))),
            /* SE */
            new Move($from, new Square(4, 3)), new Move($from, new Square(5, 2)),
            new Move($from, new Square(6, 1)),
            /* SW */
            new Move($from, new Square(2, 3)), new Move($from, new Square(1, 2, new Pawn(Piece::BLACK))),
            /* NW */
            new Move($from, new Square(2, 5)),
        ], $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesBlack()
    {
        $board = new Board(true);
        $board->setSquare(3, 4, new Bishop(Piece::BLACK));
        $from = new Square(3, 4, new Bishop(Piece::BLACK));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(5, 6, new Pawn(Piece::BLACK)); //NE
        $board->setSquare(7, 0, new Pawn(Piece::WHITE)); //SE
        $board->setSquare(1, 2, new Pawn(Piece::BLACK)); //SW
        $board->setSquare(1, 6, new Pawn(Piece::WHITE)); //NE
        $this->assertEquals([
            /* NE */
            new Move($from, new Square(4, 5)),
            /* SE */
            new Move($from, new Square(4, 3)), new Move($from, new Square(5, 2)),
            new Move($from, new Square(6, 1)), new Move($from, new Square(7, 0, new Pawn(Piece::WHITE))),
            /* SW */
            new Move($from, new Square(2, 3)),
            /* NW */
            new Move($from, new Square(2, 5)), new Move($from, new Square(1, 6, new Pawn(Piece::WHITE))),
        ], $board->getMoves(3, 4));
    }
}
