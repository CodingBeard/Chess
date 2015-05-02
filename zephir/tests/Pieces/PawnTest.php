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


use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\Pawn;

class PawnTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Pieces\Pawn::__construct
     * @uses              \CodingBeard\Chess\Pieces\Pawn
     */
    public function testConstruct()
    {
        $Pawn = new Pawn(Piece::WHITE);

        $this->assertInstanceOf('CodingBeard\Chess\Pieces\Pawn', $Pawn);
        $this->assertEquals('Pawn', $Pawn->getType());
        $this->assertEquals(Piece::WHITE, $Pawn->getColour());
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::toString
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testToString()
    {
        $Pawn = new Pawn(Piece::WHITE);

        $this->assertEquals('[0,"Pawn"]', $Pawn->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::fromString
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testFromString()
    {
        $Pawn = Piece::fromString('[0,"Pawn"]');

        $this->assertEquals(new Pawn(Piece::WHITE), $Pawn);
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::GetPotentialMoves
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testGetPotentialMoves()
    {
        $Pawn = new Pawn(Piece::WHITE);

        $this->assertEquals([
            [[0, 1]], [[0, 2]], [[1, 1]],
        ], $Pawn->getPotentialMoves(0, 0));

        $this->assertEquals([], $Pawn->getPotentialMoves(0, 7));

        $this->assertEquals([], $Pawn->getPotentialMoves(7, 7));

        $this->assertEquals([
            [[7, 1]], [[7, 2]], [[6, 1]],
        ], $Pawn->getPotentialMoves(7, 0));

        $this->assertEquals([
            [[3, 5]], [[3, 6]], [[4, 5]], [[2, 5]],
        ], $Pawn->getPotentialMoves(3, 4));
    }

}
