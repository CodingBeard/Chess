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


use CodingBeard\Chess\Board\Square;
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
     * @covers            \CodingBeard\Chess\Piece::toString
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testToString()
    {
        $King = new King(Piece::WHITE);

        $this->assertEquals('[0,"King"]', $King->toString());
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::fromString
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testFromString()
    {
        $King = Piece::fromString('[0,"King"]');

        $this->assertEquals(new King(Piece::WHITE), $King);
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::GetPotentialMoves
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testGetPotentialMoves()
    {
        $King = new King(Piece::WHITE);

        $this->assertEquals([[[0, 1]], [[1, 1]], [[1, 0]]], $King->getPotentialMoves(0, 0));
        $this->assertEquals([[[1, 7]], [[1, 6]], [[0, 6]]], $King->getPotentialMoves(0, 7));
        $this->assertEquals([[[7, 6]], [[6, 6]], [[6, 7]]], $King->getPotentialMoves(7, 7));
        $this->assertEquals([[[7, 1]], [[6, 0]], [[6, 1]]], $King->getPotentialMoves(7, 0));

        $this->assertEquals([
            [[3, 5]], [[4, 5]], [[4, 4]], [[4, 3]], [[3, 3]], [[2, 3]], [[2, 4]], [[2, 5]],
        ], $King->getPotentialMoves(3, 4));
    }

    /**
     * @covers            \CodingBeard\Chess\Piece::checkAttack
     * @uses              \CodingBeard\Chess\Piece
     */
    public function testCheckMove()
    {
        $whiteKing = new King(Piece::WHITE);
        $blackKing = new King(Piece::BLACK);

        $from = new Square(3, 0, $whiteKing);
        $emptyTo = new Square(3, 1);
        $blackTo = new Square(3, 1, $blackKing);
        $whiteTo = new Square(3, 1, $whiteKing);

        $this->assertEquals([true, 'break' => false], $whiteKing->checkMove($from, $emptyTo));
        $this->assertEquals([true, 'break' => true], $whiteKing->checkMove($from, $blackTo));
        $this->assertEquals([false, 'break' => true], $whiteKing->checkMove($from, $whiteTo));
    }
}
