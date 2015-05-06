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


use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Pawn;

class PawnTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Board\Piece\Pawn::__construct
     * @uses              \CodingBeard\Chess\Board\Piece\Pawn
     */
    public function testConstruct()
    {
        $Pawn = new Pawn(Piece::WHITE);

        $this->assertInstanceOf('CodingBeard\Chess\Board\Piece\Pawn', $Pawn);
        $this->assertEquals('Pawn', $Pawn->getType());
        $this->assertEquals(Piece::WHITE, $Pawn->getColour());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::toString
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testToString()
    {
        $Pawn = new Pawn(Piece::WHITE);

        $this->assertEquals('[0,"Pawn"]', $Pawn->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::fromString
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testFromString()
    {
        $Pawn = Piece::fromString('[0,"Pawn"]');

        $this->assertEquals(new Pawn(Piece::WHITE), $Pawn);
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::GetPotentialMoves
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testGetPotentialMovesWhite()
    {
        $Pawn = new Pawn(Piece::WHITE);

        $this->assertEquals([
            [[0, 1], [0, 2]], [[1, 1]],
        ], $Pawn->getPotentialMoves(0, 0));

        $this->assertEquals([], $Pawn->getPotentialMoves(0, 7));

        $this->assertEquals([], $Pawn->getPotentialMoves(7, 7));

        $this->assertEquals([
            [[7, 1], [7, 2]], [[6, 1]],
        ], $Pawn->getPotentialMoves(7, 0));

        $this->assertEquals([
            [[3, 5], [3, 6]], [[4, 5]], [[2, 5]],
        ], $Pawn->getPotentialMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::GetPotentialMoves
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testGetPotentialMovesWhiteBlack()
    {
        $Pawn = new Pawn(Piece::BLACK);

        $this->assertEquals([], $Pawn->getPotentialMoves(0, 0));

        $this->assertEquals([
            [[0, 6], [0, 5]], [[1, 6]],
        ], $Pawn->getPotentialMoves(0, 7));

        $this->assertEquals([
            [[7, 6], [7, 5]], [[6, 6]],
        ], $Pawn->getPotentialMoves(7, 7));

        $this->assertEquals([], $Pawn->getPotentialMoves(7, 0));

        $this->assertEquals([
            [[3, 3], [3, 2]], [[4, 3]], [[2, 3]],
        ], $Pawn->getPotentialMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Board\Piece::checkMove
     * @uses              \CodingBeard\Chess\Board\Piece
     */
    public function testCheckMove()
    {
        $whitePawn = new Pawn(Piece::WHITE);
        $blackPawn = new Pawn(Piece::BLACK);

        $from = new Square(3, 1, $whitePawn);
        $emptyTo = new Square(3, 2);
        $emptyToTwo = new Square(3, 3);
        $blackTo = new Square(3, 2, $blackPawn);
        $whiteTo = new Square(3, 2, $whitePawn);

        $this->assertEquals([true, 'break' => false], $whitePawn->checkMove($from, $emptyTo));
        $this->assertEquals([true, 'break' => false], $whitePawn->checkMove($from, $emptyToTwo));
        $this->assertEquals([false, 'break' => true], $whitePawn->checkMove($from, $blackTo));
        $this->assertEquals([false, 'break' => true], $whitePawn->checkMove($from, $whiteTo));
    }

}
