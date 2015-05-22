<?php

/*
* SetPossibleMoves Test
*
* @category
* @package Chess
* @author Tim Marshall <Tim@CodingBeard.com>
* @copyright (c) 2015, Tim Marshall
* @license New BSD License
*/


use CodingBeard\Chess\Board;
use CodingBeard\Chess\Board\Square;
use CodingBeard\Chess\Board\Move;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\Pawn;
use CodingBeard\Chess\Board\Piece\Knight;

class SetPossibleMovesTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Board::setPossibleMoves
     * @uses              \CodingBeard\Chess\Board
     */
    public function testsetPossibleMovesDefault()
    {
        $board = new Board();
        $board->setDefaults();

        $board->setPossibleMoves();

        $this->assertEquals([
            Piece::WHITE => [
                new Move(new Square(0, 1, new Pawn(Piece::WHITE)), new Square(0, 2)),
                new Move(new Square(0, 1, new Pawn(Piece::WHITE)), new Square(0, 3)),
                new Move(new Square(1, 0, new Knight(Piece::WHITE)), new Square(2, 2)),
                new Move(new Square(1, 0, new Knight(Piece::WHITE)), new Square(0, 2)),
                new Move(new Square(1, 1, new Pawn(Piece::WHITE)), new Square(1, 2)),
                new Move(new Square(1, 1, new Pawn(Piece::WHITE)), new Square(1, 3)),
                new Move(new Square(2, 1, new Pawn(Piece::WHITE)), new Square(2, 2)),
                new Move(new Square(2, 1, new Pawn(Piece::WHITE)), new Square(2, 3)),
                new Move(new Square(3, 1, new Pawn(Piece::WHITE)), new Square(3, 2)),
                new Move(new Square(3, 1, new Pawn(Piece::WHITE)), new Square(3, 3)),
                new Move(new Square(4, 1, new Pawn(Piece::WHITE)), new Square(4, 2)),
                new Move(new Square(4, 1, new Pawn(Piece::WHITE)), new Square(4, 3)),
                new Move(new Square(5, 1, new Pawn(Piece::WHITE)), new Square(5, 2)),
                new Move(new Square(5, 1, new Pawn(Piece::WHITE)), new Square(5, 3)),
                new Move(new Square(6, 0, new Knight(Piece::WHITE)), new Square(7, 2)),
                new Move(new Square(6, 0, new Knight(Piece::WHITE)), new Square(5, 2)),
                new Move(new Square(6, 1, new Pawn(Piece::WHITE)), new Square(6, 2)),
                new Move(new Square(6, 1, new Pawn(Piece::WHITE)), new Square(6, 3)),
                new Move(new Square(7, 1, new Pawn(Piece::WHITE)), new Square(7, 2)),
                new Move(new Square(7, 1, new Pawn(Piece::WHITE)), new Square(7, 3)),
            ],
            Piece::BLACK => [
                new Move(new Square(0, 6, new Pawn(Piece::BLACK)), new Square(0, 5)),
                new Move(new Square(0, 6, new Pawn(Piece::BLACK)), new Square(0, 4)),
                new Move(new Square(1, 6, new Pawn(Piece::BLACK)), new Square(1, 5)),
                new Move(new Square(1, 6, new Pawn(Piece::BLACK)), new Square(1, 4)),
                new Move(new Square(1, 7, new Knight(Piece::BLACK)), new Square(2, 5)),
                new Move(new Square(1, 7, new Knight(Piece::BLACK)), new Square(0, 5)),
                new Move(new Square(2, 6, new Pawn(Piece::BLACK)), new Square(2, 5)),
                new Move(new Square(2, 6, new Pawn(Piece::BLACK)), new Square(2, 4)),
                new Move(new Square(3, 6, new Pawn(Piece::BLACK)), new Square(3, 5)),
                new Move(new Square(3, 6, new Pawn(Piece::BLACK)), new Square(3, 4)),
                new Move(new Square(4, 6, new Pawn(Piece::BLACK)), new Square(4, 5)),
                new Move(new Square(4, 6, new Pawn(Piece::BLACK)), new Square(4, 4)),
                new Move(new Square(5, 6, new Pawn(Piece::BLACK)), new Square(5, 5)),
                new Move(new Square(5, 6, new Pawn(Piece::BLACK)), new Square(5, 4)),
                new Move(new Square(6, 6, new Pawn(Piece::BLACK)), new Square(6, 5)),
                new Move(new Square(6, 6, new Pawn(Piece::BLACK)), new Square(6, 4)),
                new Move(new Square(6, 7, new Knight(Piece::BLACK)), new Square(7, 5)),
                new Move(new Square(6, 7, new Knight(Piece::BLACK)), new Square(5, 5)),
                new Move(new Square(7, 6, new Pawn(Piece::BLACK)), new Square(7, 5)),
                new Move(new Square(7, 6, new Pawn(Piece::BLACK)), new Square(7, 4)),
            ]
        ], $board->getPossibleMoves());
    }
}
