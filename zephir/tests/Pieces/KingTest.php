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


use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\King;

class KingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Pieces\King::__construct
     * @uses              \CodingBeard\Chess\Pieces\King
     */
    public function testConstruct()
    {
        $King = new King(Piece::WHITE);

        $this->assertInstanceOf('CodingBeard\Chess\Pieces\King', $King);
        $this->assertEquals('King', $King->getType());
        $this->assertEquals(Piece::WHITE, $King->getColour());
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Piece::toString
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testToString()
    {
        $King = new King(Piece::WHITE);

        $this->assertEquals('[0,"King"]', $King->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Piece::fromString
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testFromString()
    {
        $King = Piece::fromString('[0,"King"]');

        $this->assertEquals(new King(Piece::WHITE), $King);
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Piece::getMoves
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testGetMoves()
    {
        $King = new King(Piece::WHITE);

        $this->assertEquals([[0, 1], [1, 1], [1, 0]], $King->getMoves(0, 0));
        $this->assertEquals([[1, 7], [1, 6], [0, 6]], $King->getMoves(0, 7));
        $this->assertEquals([[7, 6], [6, 6], [6, 7]], $King->getMoves(7, 7));
        $this->assertEquals([[7, 1], [6, 0], [6, 1]], $King->getMoves(7, 0));

        $this->assertEquals([
            [3, 5], [4, 5], [4, 4], [4, 3], [3, 3], [2, 3], [2, 4], [2, 5],
        ], $King->getMoves(3, 4));
    }
}
