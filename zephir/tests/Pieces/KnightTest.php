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

        $this->assertEquals('0,Knight', $Knight->toString());
    }

}
