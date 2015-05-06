<?php

/*
 * Square Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Pawn;

class SquareTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Board\Square::__construct
     * @uses              \CodingBeard\Chess\Board\Square
     */
    public function testConstruct()
    {
        $Square = new Square(0, 1, new Pawn(Piece::WHITE));

        $this->assertInstanceOf('CodingBeard\Chess\Board\Square', $Square);
        $this->assertEquals(0, $Square->getX());
        $this->assertEquals(1, $Square->getY());
        $this->assertInstanceOf('CodingBeard\Chess\Board\Piece\Pawn', $Square->getPiece());

        $Square = new Square(0, 1);
        $this->assertEquals(false, $Square->getPiece());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Square::toString
     * @uses              \CodingBeard\Chess\Board\Square
     */
    public function testToString()
    {
        $Pawn = new Square(0, 1, new Pawn(Piece::WHITE));

        $this->assertEquals('[0,1,[0,"Pawn"]]', $Pawn->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Square::fromString
     * @uses              \CodingBeard\Chess\Board\Square
     */
    public function testFromString()
    {
        $Square = Square::fromString('[0,1,[0,"Pawn"]]');

        $this->assertEquals(new Square(0, 1, new Pawn(Piece::WHITE)), $Square);
    }

}
