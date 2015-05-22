<?php

/*
* Checkmate Test
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
use CodingBeard\Chess\Game;

class CheckmateTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers            \CodingBeard\Chess\Game::isCheckMate
     * @covers            \CodingBeard\Chess\Ai::isCheckMate
     * @uses              \CodingBeard\Chess\Game
     * @uses              \CodingBeard\Chess\Ai
     */
    public function testIsCheckMate()
    {
        $board = new Board();
        $board->setDefaults();
        $board->makeMove(new Move(new Square(4, 1, new Pawn(Piece::WHITE)), new Square(4, 4)));
        $board->makeMove(new Move(new Square(5, 6, new Pawn(Piece::BLACK)), new Square(5, 4)));
        $board->makeMove(new Move(new Square(3, 0, new Pawn(Piece::WHITE)), new Square(7, 4)));
        $game = new Game($board);

        $this->assertFalse($game->isCheckMate($board->getTurn()));
    }
}
