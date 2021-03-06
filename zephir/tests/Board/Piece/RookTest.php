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


use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Rook;

class RookTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Board\Piece\Rook::__construct
     * @uses              \CodingBeard\Chess\Board\Piece\Rook
     */
    public function testConstruct()
    {
        $Rook = new Rook(Piece::WHITE);

        $this->assertInstanceOf('CodingBeard\Chess\Board\Piece\Rook', $Rook);
        $this->assertEquals('Rook', $Rook->getType());
        $this->assertEquals(Piece::WHITE, $Rook->getColour());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::toString
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testToString()
    {
        $Rook = new Rook(Piece::WHITE);

        $this->assertEquals('[0,"Rook"]', $Rook->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::fromString
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testFromString()
    {
        $Rook = Piece::fromString('[0,"Rook"]');

        $this->assertEquals(new Rook(Piece::WHITE), $Rook);
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::GetPotentialMoves
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testGetPotentialMoves()
    {
        $Rook = new Rook(Piece::WHITE);

        $this->assertEquals([
            [[0, 1], [0, 2], [0, 3], [0, 4], [0, 5], [0, 6], [0, 7]],
            [[1, 0], [2, 0], [3, 0], [4, 0], [5, 0], [6, 0], [7, 0]],
        ], $Rook->getPotentialMoves(0, 0));

        $this->assertEquals([
            [[1, 7], [2, 7], [3, 7], [4, 7], [5, 7], [6, 7], [7, 7]],
            [[0, 6], [0, 5], [0, 4], [0, 3], [0, 2], [0, 1], [0, 0]],
        ], $Rook->getPotentialMoves(0, 7));

        $this->assertEquals([
            [[7, 6], [7, 5], [7, 4], [7, 3], [7, 2], [7, 1], [7, 0]],
            [[6, 7], [5, 7], [4, 7], [3, 7], [2, 7], [1, 7], [0, 7]],
        ], $Rook->getPotentialMoves(7, 7));

        $this->assertEquals([
            [[7, 1], [7, 2], [7, 3], [7, 4], [7, 5], [7, 6], [7, 7]],
            [[6, 0], [5, 0], [4, 0], [3, 0], [2, 0], [1, 0], [0, 0]],
        ], $Rook->getPotentialMoves(7, 0));

        $this->assertEquals([
            [[3, 5], [3, 6], [3, 7]],
            [[4, 4], [5, 4], [6, 4], [7, 4]],
            [[3, 3], [3, 2], [3, 1], [3, 0]],
            [[2, 4], [1, 4], [0, 4]],
        ], $Rook->getPotentialMoves(3, 4));
    }
}
