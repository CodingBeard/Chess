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


use CodingBeard\Chess\Game;

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
    }

}
