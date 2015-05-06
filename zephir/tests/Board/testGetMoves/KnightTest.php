<?php

/*
 * Knight Test
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
use CodingBeard\Chess\Board\Piece\Knight;
use CodingBeard\Chess\Board\Piece\Pawn;

class GetMovesKnightTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMoves()
    {
        $board = new Board();
        $board->setSquare(3, 4, new Knight(Piece::WHITE));
        $from = new Square(3, 4, new Knight(Piece::WHITE));

        $this->assertEquals([
            new Move($from, new Square(4, 6)),
            new Move($from, new Square(5, 5)),
            new Move($from, new Square(5, 3)),
            new Move($from, new Square(4, 2)),
            new Move($from, new Square(2, 2)),
            new Move($from, new Square(1, 3)),
            new Move($from, new Square(1, 5)),
            new Move($from, new Square(2, 6)),
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
        $board->setSquare(3, 4, new Knight(Piece::WHITE));
        $from = new Square(3, 4, new Knight(Piece::WHITE));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(4, 6, new Pawn(Piece::WHITE)); //NNE
        $board->setSquare(5, 5, new Pawn(Piece::BLACK)); //NEE
        $board->setSquare(5, 3, new Pawn(Piece::WHITE)); //SEE
        $board->setSquare(4, 2, new Pawn(Piece::BLACK)); //SSE
        $board->setSquare(2, 2, new Pawn(Piece::WHITE)); //SSW
        $board->setSquare(1, 3, new Pawn(Piece::BLACK)); //SWW
        $board->setSquare(1, 5, new Pawn(Piece::WHITE)); //NWW
        $board->setSquare(2, 6, new Pawn(Piece::BLACK)); //NNW
        $this->assertEquals([
            /* NNE */

            /* NEE */
            new Move($from, new Square(5, 5, new Pawn(Piece::BLACK))),
            /* SEE */

            /* SSE */
            new Move($from, new Square(4, 2, new Pawn(Piece::BLACK))),
            /* SSW */

            /* SWW */
            new Move($from, new Square(1, 3, new Pawn(Piece::BLACK))),
            /* NWW */

            /* NNW */
            new Move($from, new Square(2, 6, new Pawn(Piece::BLACK))),
        ], $board->getMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board::getMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testGetMovesObstaclesBlack()
    {
        $board = new Board();
        $board->setSquare(3, 4, new Knight(Piece::BLACK));
        $from = new Square(3, 4, new Knight(Piece::BLACK));

        /* white/black obstacles alternating and increasing/decreasing in distance */
        $board->setSquare(4, 6, new Pawn(Piece::WHITE)); //NNE
        $board->setSquare(5, 5, new Pawn(Piece::BLACK)); //NEE
        $board->setSquare(5, 3, new Pawn(Piece::WHITE)); //SEE
        $board->setSquare(4, 2, new Pawn(Piece::BLACK)); //SSE
        $board->setSquare(2, 2, new Pawn(Piece::WHITE)); //SSW
        $board->setSquare(1, 3, new Pawn(Piece::BLACK)); //SWW
        $board->setSquare(1, 5, new Pawn(Piece::WHITE)); //NWW
        $board->setSquare(2, 6, new Pawn(Piece::BLACK)); //NNW
        $this->assertEquals([
            /* NNE */
            new Move($from, new Square(4, 6, new Pawn(Piece::WHITE))),
            /* NEE */

            /* SEE */
            new Move($from, new Square(5, 3, new Pawn(Piece::WHITE))),
            /* SSE */

            /* SSW */
            new Move($from, new Square(2, 2, new Pawn(Piece::WHITE))),
            /* SWW */

            /* NWW */
            new Move($from, new Square(1, 5, new Pawn(Piece::WHITE))),
        ], $board->getMoves(3, 4));
    }

}
