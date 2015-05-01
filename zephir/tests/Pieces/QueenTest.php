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


use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\Queen;

class QueenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Pieces\Queen::__construct
     * @uses              \CodingBeard\Chess\Pieces\Queen
     */
    public function testConstruct()
    {
        $Queen = new Queen(Piece::WHITE);

        $this->assertInstanceOf('CodingBeard\Chess\Pieces\Queen', $Queen);
        $this->assertEquals('Queen', $Queen->getType());
        $this->assertEquals(Piece::WHITE, $Queen->getColour());
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Piece::toString
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testToString()
    {
        $Queen = new Queen(Piece::WHITE);

        $this->assertEquals('[0,"Queen"]', $Queen->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Piece::fromString
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testFromString()
    {
        $Queen = Piece::fromString('[0,"Queen"]');

        $this->assertEquals(new Queen(Piece::WHITE), $Queen);
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Piece::getMoves
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testGetMoves()
    {
        $Queen = new Queen(Piece::WHITE);

        $this->assertEquals([
            [0, 1], [0, 2], [0, 3], [0, 4], [0, 5], [0, 6], [0, 7],
            [1, 1], [2, 2], [3, 3], [4, 4], [5, 5], [6, 6], [7, 7],
            [1, 0], [2, 0], [3, 0], [4, 0], [5, 0], [6, 0], [7, 0],
        ], $Queen->getMoves(0, 0));

        $this->assertEquals([
            [1, 7], [2, 7], [3, 7], [4, 7], [5, 7], [6, 7], [7, 7],
            [1, 6], [2, 5], [3, 4], [4, 3], [5, 2], [6, 1], [7, 0],
            [0, 6], [0, 5], [0, 4], [0, 3], [0, 2], [0, 1], [0, 0],
        ], $Queen->getMoves(0, 7));

        $this->assertEquals([
            [7, 6], [7, 5], [7, 4], [7, 3], [7, 2], [7, 1], [7, 0],
            [6, 6], [5, 5], [4, 4], [3, 3], [2, 2], [1, 1], [0, 0],
            [6, 7], [5, 7], [4, 7], [3, 7], [2, 7], [1, 7], [0, 7],
        ], $Queen->getMoves(7, 7));

        $this->assertEquals([
            [7, 1], [7, 2], [7, 3], [7, 4], [7, 5], [7, 6], [7, 7],
            [6, 0], [5, 0], [4, 0], [3, 0], [2, 0], [1, 0], [0, 0],
            [6, 1], [5, 2], [4, 3], [3, 4], [2, 5], [1, 6], [0, 7],
        ], $Queen->getMoves(7, 0));

        $this->assertEquals([
            [3, 5], [3, 6], [3, 7],
            [4, 5], [5, 6], [6, 7],
            [4, 4], [5, 4], [6, 4], [7, 4],
            [4, 3], [5, 2], [6, 1], [7, 0],
            [3, 3], [3, 2], [3, 1], [3, 0],
            [2, 3], [1, 2], [0, 1],
            [2, 4], [1, 4], [0, 4],
            [2, 5], [1, 6], [0, 7],
        ], $Queen->getMoves(3, 4));
    }
}
