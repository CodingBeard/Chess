<?php

/*
 * King Test
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
use CodingBeard\Chess\Pieces\King;

class GetMovesKingTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesNoObstacles()
    {
        $board = new Board(true);
        $board->setSquare(3, 4, new King(Piece::WHITE));
        $from = new Square(3, 4, new King(Piece::WHITE));

        $this->assertEquals([
            /* N */
            new Move($from, new Square(3, 5)),
            /* NE */
            new Move($from, new Square(4, 5)),
            /* E */
            new Move($from, new Square(4, 4)),
            /* SE */
            new Move($from, new Square(4, 3)),
            /* S */
            new Move($from, new Square(3, 3)),
            /* SW */
            new Move($from, new Square(2, 3)),
            /* W */
            new Move($from, new Square(2, 4)),
            /* NW */
            new Move($from, new Square(2, 5)),
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
        $board->setSquare(3, 4, new King(Piece::WHITE));
        $from = new Square(3, 4, new King(Piece::WHITE));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 5, new Pawn(Piece::WHITE)); //N
        $board->setSquare(4, 5, new Pawn(Piece::BLACK)); //NE
        $board->setSquare(4, 4, new Pawn(Piece::WHITE)); //E
        $board->setSquare(4, 3, new Pawn(Piece::BLACK)); //SE
        $board->setSquare(3, 3, new Pawn(Piece::WHITE)); //S
        $board->setSquare(2, 3, new Pawn(Piece::BLACK)); //SW
        $board->setSquare(2, 4, new Pawn(Piece::WHITE)); //W
        $board->setSquare(2, 5, new Pawn(Piece::BLACK)); //NE
        $this->assertEquals([
            /* N */

            /* NE */
            new Move($from, new Square(4, 5, new Pawn(Piece::BLACK))),
            /* E */

            /* SE */
            new Move($from, new Square(4, 3, new Pawn(Piece::BLACK))),
            /* S */

            /* SW */
            new Move($from, new Square(2, 3, new Pawn(Piece::BLACK))),
            /* W */

            /* NW */
            new Move($from, new Square(2, 5, new Pawn(Piece::BLACK))),
        ], $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesBlack()
    {
        $board = new Board(true);
        $board->setSquare(3, 4, new King(Piece::BLACK));
        $from = new Square(3, 4, new King(Piece::BLACK));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(3, 5, new Pawn(Piece::WHITE)); //N
        $board->setSquare(4, 5, new Pawn(Piece::BLACK)); //NE
        $board->setSquare(4, 4, new Pawn(Piece::WHITE)); //E
        $board->setSquare(4, 3, new Pawn(Piece::BLACK)); //SE
        $board->setSquare(3, 3, new Pawn(Piece::WHITE)); //S
        $board->setSquare(2, 3, new Pawn(Piece::BLACK)); //SW
        $board->setSquare(2, 4, new Pawn(Piece::WHITE)); //W
        $board->setSquare(2, 5, new Pawn(Piece::BLACK)); //NE
        $this->assertEquals([
            /* N */
            new Move($from, new Square(3, 5, new Pawn(Piece::WHITE))),
            /* NE */

            /* E */
            new Move($from, new Square(4, 4, new Pawn(Piece::WHITE))),
            /* SE */

            /* S */
            new Move($from, new Square(3, 3, new Pawn(Piece::WHITE))),
            /* SW */

            /* W */
            new Move($from, new Square(2, 4, new Pawn(Piece::WHITE))),
            /* NW */

        ], $board->getMoves(3, 4));
    }
}
