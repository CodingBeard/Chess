<?php

/**
 * Error Pages
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard;

use models\Pages;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception;
use Phalcon\Mvc\User\Component;

class DispatchingExceptionHandler extends Component
{

    /**
     * Serve pagecontents system or
     * Redirect to a 404 or 500 page if we catch an exception
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @param Exception $exception
     * @return boolean
     */
    public function beforeException($event, $dispatcher, $exception)
    {
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:

                //filter for case-insensitivity and hyphens
                $url = str_replace('-', '', strtolower(substr($_SERVER['REQUEST_URI'], 1)));

                $page = Pages::findFirst([
                    'url = :a: AND standalone = 1',
                    'bind' => ['a' => $url]
                ]);
                if ($page) {
                    $dispatcher->forward([
                        'controller' => 'pagecontents',
                        'action' => 'view',
                        'params' => [$page->id]
                    ]);
                }
                else {
                    $dispatcher->forward([
                        'controller' => 'error',
                        'action' => 'notFound',
                    ]);
                }
                return false;
            default:
                if (!$this->config->application->showErrors) {
                    $dispatcher->forward([
                        'controller' => 'error',
                        'action' => 'index',
                    ]);
                    return false;
                }
        }
    }

}
