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


use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\Bishop;

class BishopTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Pieces\Bishop::__construct
     * @uses              \CodingBeard\Chess\Pieces\Bishop
     */
    public function testConstruct()
    {
        $Bishop = new Bishop(Piece::WHITE);

        $this->assertInstanceOf('CodingBeard\Chess\Pieces\Bishop', $Bishop);
        $this->assertEquals('Bishop', $Bishop->getType());
        $this->assertEquals(Piece::WHITE, $Bishop->getColour());
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::toString
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testToString()
    {
        $Bishop = new Bishop(Piece::WHITE);

        $this->assertEquals('[0,"Bishop"]', $Bishop->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::fromString
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testFromString()
    {
        $Bishop = Piece::fromString('[0,"Bishop"]');

        $this->assertEquals(new Bishop(Piece::WHITE), $Bishop);
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::GetPotentialMoves
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testGetPotentialMoves()
    {
        $Bishop = new Bishop(Piece::WHITE);

        $this->assertEquals([[[1, 1], [2, 2], [3, 3], [4, 4], [5, 5], [6, 6], [7, 7],]], $Bishop->getPotentialMoves(0, 0));
        $this->assertEquals([[[1, 6], [2, 5], [3, 4], [4, 3], [5, 2], [6, 1], [7, 0],]], $Bishop->getPotentialMoves(0, 7));
        $this->assertEquals([[[6, 6], [5, 5], [4, 4], [3, 3], [2, 2], [1, 1], [0, 0],]], $Bishop->getPotentialMoves(7, 7));
        $this->assertEquals([[[6, 1], [5, 2], [4, 3], [3, 4], [2, 5], [1, 6], [0, 7],]], $Bishop->getPotentialMoves(7, 0));

        $this->assertEquals([
            [[4, 5], [5, 6], [6, 7]],
            [[4, 3], [5, 2], [6, 1], [7, 0]],
            [[2, 3], [1, 2], [0, 1]],
            [[2, 5], [1, 6], [0, 7]],
        ], $Bishop->getPotentialMoves(3, 4));
    }
}
