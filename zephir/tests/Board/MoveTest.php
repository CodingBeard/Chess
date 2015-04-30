<?php

/*
 * Move Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Piece;
use CodingBeard\Chess\Pieces\Knight;
use CodingBeard\Chess\Pieces\Pawn;

class MoveTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Board\Move::__construct
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testConstruct()
    {
        $Move = new Move();
        $this->assertInstanceOf('CodingBeard\Chess\Board\Move', $Move);

        $Move = new Move(new Square(0, 0), new Square(1, 1));

        $this->assertInstanceOf('CodingBeard\Chess\Board\Move', $Move);
        $this->assertEquals(new Square(0, 0), $Move->getFrom());
        $this->assertEquals(new Square(1, 1), $Move->getTo());
        $this->assertEquals(false, $Move->getNoClip());
        $this->assertEquals(false, $Move->getObstacle());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Move::setFrom
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testSetFrom()
    {
        $Move = new Move();
        $Move->setFrom(new Square(0, 0, new Knight(Piece::WHITE)));

        $this->assertEquals(new Square(0, 0, new Knight(Piece::WHITE)), $Move->getFrom());
        $this->assertEquals(true, $Move->getNoClip());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Move::setTo
     * @uses              \CodingBeard\Chess\Board\Move
     */
    public function testSetTo()
    {
        $Move = new Move(new Square(0, 0, new Pawn(Piece::WHITE)));
        $Move->setTo(new Square(0, 1, new Pawn(Piece::WHITE)));

        $this->assertEquals(true, $Move->getObstacle());
        $this->assertEquals(new Square(0, 1, new Pawn(Piece::WHITE)), $Move->getTo());

        $Move = new Move(new Square(0, 0, new Knight(Piece::WHITE)));
        $Move->setTo(new Square(0, 1, new Pawn(Piece::WHITE)));
        $this->assertEquals(false, $Move->getObstacle());
    }

}
