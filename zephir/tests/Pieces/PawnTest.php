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
     * @covers            \CodingBeard\Chess\Pieces\Piece::toString
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testToString()
    {
        $Pawn = new Pawn(Piece::WHITE);

        $this->assertEquals('0,Pawn', $Pawn->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Pieces\Piece::fromString
     * @uses              \CodingBeard\Chess\Pieces\Piece
     */
    public function testFromString()
    {
        $Pawn = Piece::fromString('0,Pawn');

        $this->assertEquals(new Pawn(Piece::WHITE), $Pawn);
    }

}
