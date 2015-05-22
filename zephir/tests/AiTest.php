<?php

/*
 * Ai Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Ai;
use CodingBeard\Chess\Board;
use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Pawn;

class AiTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Ai::__construct
     * @uses              \CodingBeard\Chess\Ai
     */
    public function testConstruct()
    {
        $Ai = new Ai();

        $this->assertInstanceOf('CodingBeard\Chess\Ai', $Ai);
    }

    /**
     * @covers            \CodingBeard\Chess\Ai::checkMove
     * @uses              \CodingBeard\Chess\Ai
     */
    public function testCheckMove()
    {
        $Ai = new Ai();
        $board = new Board();
        $board->setDefaults();
        $move = new Move(
            new Square(1, 1, new Pawn(Piece::WHITE)),
            new Square(1, 2)
        );

        $this->assertEquals(Ai::VALID_MOVE, $Ai->checkMove($move, $board));


        $move = new Move(
            new Square(1, 7, new Pawn(Piece::BLACK)),
            new Square(1, 6)
        );

        $this->assertEquals(Ai::NOT_TURN, $Ai->checkMove($move, $board));


        $move = new Move(
            new Square(1, 1, new Pawn(Piece::WHITE)),
            new Square(1, 4)
        );

        $this->assertEquals(Ai::INVALID_MOVE, $Ai->checkMove($move, $board));


        $move = new Move(
            new Square(1, 1, new Pawn(Piece::WHITE)),
            new Square(1, 2, new Pawn(Piece::WHITE))
        );

        $this->assertEquals(Ai::INVALID_MOVE, $Ai->checkMove($move, $board));


        $move = new Move(
            new Square(1, 1, new Pawn(Piece::WHITE)),
            new Square(2, 2, new Pawn(Piece::BLACK))
        );
        $board->setSquare(2, 2, new Pawn(Piece::BLACK));

        $this->assertEquals(Ai::VALID_MOVE, $Ai->checkMove($move, $board));
    }

}
