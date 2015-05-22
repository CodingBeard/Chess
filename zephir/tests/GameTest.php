<?php

/*
 * Game Test
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */


use CodingBeard\Chess\Board;
use CodingBeard\Chess\Game;
use CodingBeard\Chess\Board\Piece;
use CodingBeard\Chess\Board\Piece\King;
use CodingBeard\Chess\Board\Piece\Rook;

class GameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers            \CodingBeard\Chess\Game::__construct
     * @uses              \CodingBeard\Chess\Game
     */
    public function testConstruct()
    {
        $Game = new Game();

        $this->assertInstanceOf('CodingBeard\Chess\Game', $Game);
        $this->assertInstanceOf('CodingBeard\Chess\Ai', $Game->getAi());
        $this->assertInstanceOf('CodingBeard\Chess\Board', $Game->getBoard());
    }

    /**
     * @covers            \CodingBeard\Chess\Game::isCheck
     * @covers            \CodingBeard\Chess\Ai::isCheck
     * @uses              \CodingBeard\Chess\Game
     * @uses              \CodingBeard\Chess\Ai
     */
    public function testIsCheck()
    {
        $board = new Board();
        $board->setSquare(0, 7, new King(Piece::WHITE));
        $board->setSquare(0, 2, new Rook(Piece::BLACK));
        $game = new Game($board);

        $this->assertTrue($game->isCheck(Piece::WHITE));

        $this->assertFalse($game->isCheck(Piece::BLACK));

        $board->setSquare(0, 2, false);
        $board->setSquare(1, 2, new Rook(Piece::WHITE));

        $this->assertFalse($game->isCheck(Piece::WHITE));
    }

}
