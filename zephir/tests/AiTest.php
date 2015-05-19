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

        $this->assertInstanceOf('CodingBeard\Chess\Ai', $Ai);
    }

}
