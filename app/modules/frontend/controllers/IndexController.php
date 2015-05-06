<?php

/**
 * Index controller, url: / | /index/
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace frontend\controllers;

use CodingBeard\Chess\Board;

class IndexController extends ControllerBase
{

    /**
     * Index page
     */
    public function indexAction()
    {
        $this->tag->appendTitle("Home");
        $board = new Board();
        $board->setDefaults();
        $this->view->board = $board;
    }

}
