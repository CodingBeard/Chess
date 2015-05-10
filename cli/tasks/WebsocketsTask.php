<?php
use CodingBeard\Chess\Websocket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

/**
 * Websockets task
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */
class WebsocketsTask extends \Phalcon\CLI\Task
{

    public function mainAction()
    {
        $pidfile = __DIR__ . '/../pids/websockets.pid';
        if (is_file($pidfile)) {
            $pid = file_get_contents($pidfile);
            if (is_dir('/proc/' . $pid) && $pid) {
                die;
            }
        }
        file_put_contents(__DIR__ . '/../pids/websockets.pid', getmypid());

        /**
         * Remove pid when done
         */
        register_shutdown_function(function () {
            unlink(__DIR__ . '/../pids/websockets.pid');
        });

        $socket = new Websocket();
        $this->di->set('socket', $socket, true);

        $wsServer = new WsServer($socket);


        $ioServer = IoServer::factory(
            new HttpServer($wsServer),
            8080
        );

        $ioServer->run();
    }

}
