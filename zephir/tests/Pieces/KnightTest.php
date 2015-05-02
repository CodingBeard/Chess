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


use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\Knight;

class KnightTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Pieces\Knight::__construct
     * @uses              \CodingBeard\Chess\Pieces\Knight
     */
    public function testConstruct()
    {
        $Knight = new Knight(Piece::WHITE);

        $this->assertInstanceOf('CodingBeard\Chess\Pieces\Knight', $Knight);
        $this->assertEquals('Knight', $Knight->getType());
        $this->assertEquals(Piece::WHITE, $Knight->getColour());
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Knight::toString
     * @uses              \CodingBeard\Chess\Pieces\Knight
     */
    public function testToString()
    {
        $Knight = new Knight(Piece::WHITE);

        $this->assertEquals('[0,"Knight"]', $Knight->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::GetPotentialMoves
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testGetPotentialMoves()
    {
        $Knight = new Knight(Piece::WHITE);

        $this->assertEquals([
            [[1, 2]], [[2, 1]],
        ], $Knight->getPotentialMoves(0, 0));

        $this->assertEquals([
            [[2, 6]], [[1, 5]],
        ], $Knight->getPotentialMoves(0, 7));

        $this->assertEquals([
            [[6, 5]], [[5, 6]],
        ], $Knight->getPotentialMoves(7, 7));

        $this->assertEquals([
            [[5, 1]], [[6, 2]],
        ], $Knight->getPotentialMoves(7, 0));

        $this->assertEquals([
            [[4, 6]], [[5, 5]], [[5, 3]], [[4, 2]], [[2, 2]], [[1, 3]], [[1, 5]], [[2, 6]],
        ], $Knight->getPotentialMoves(3, 4));
    }

}
