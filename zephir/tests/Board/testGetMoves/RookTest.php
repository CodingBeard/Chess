<?php

/*
 * Rook Test
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
use CodingBeard\Chess\Pieces\Rook;

class GetMovesRookTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesNoObstacles()
    {
        $board = new Board(true);
        $board->setSquare(3, 4, new Rook(Piece::WHITE));
        $from = new Square(3, 4, new Rook(Piece::WHITE));

        $this->assertEquals([
            /* N */
            new Move($from, new Square(3, 5)), new Move($from, new Square(3, 6)), new Move($from, new Square(3, 7)),
            /* E */
            new Move($from, new Square(4, 4)), new Move($from, new Square(5, 4)),
            new Move($from, new Square(6, 4)), new Move($from, new Square(7, 4)),
            /* S */
            new Move($from, new Square(3, 3)), new Move($from, new Square(3, 2)),
            new Move($from, new Square(3, 1)), new Move($from, new Square(3, 0)),
            /* W */
            new Move($from, new Square(2, 4)), new Move($from, new Square(1, 4)), new Move($from, new Square(0, 4)),
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
        $board->setSquare(3, 4, new Rook(Piece::WHITE));
        $from = new Square(3, 4, new Rook(Piece::WHITE));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 5, new Pawn(Piece::WHITE)); //N
        $board->setSquare(6, 4, new Pawn(Piece::BLACK)); //E
        $board->setSquare(3, 1, new Pawn(Piece::WHITE)); //S
        $board->setSquare(2, 4, new Pawn(Piece::BLACK)); //W
        $this->assertEquals([
            /* N */

            /* E */
            new Move($from, new Square(4, 4)), new Move($from, new Square(5, 4)),
            new Move($from, new Square(6, 4, new Pawn(Piece::BLACK))),
            /* S */
            new Move($from, new Square(3, 3)), new Move($from, new Square(3, 2)),
            /* W */
            new Move($from, new Square(2, 4, new Pawn(Piece::BLACK))),
        ], $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesBlack()
    {
        $board = new Board(true);
        $board->setSquare(3, 4, new Rook(Piece::BLACK));
        $from = new Square(3, 4, new Rook(Piece::BLACK));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 5, new Pawn(Piece::WHITE)); //N
        $board->setSquare(6, 4, new Pawn(Piece::BLACK)); //E
        $board->setSquare(3, 1, new Pawn(Piece::WHITE)); //S
        $board->setSquare(2, 4, new Pawn(Piece::BLACK)); //W
        $this->assertEquals([
            /* N */
            new Move($from, new Square(3, 5, new Pawn(Piece::WHITE))),
            /* E */
            new Move($from, new Square(4, 4)), new Move($from, new Square(5, 4)),
            /* S */
            new Move($from, new Square(3, 3)), new Move($from, new Square(3, 2)),
            new Move($from, new Square(3, 1, new Pawn(Piece::WHITE))),
            /* W */

        ], $board->getMoves(3, 4));
    }
}
