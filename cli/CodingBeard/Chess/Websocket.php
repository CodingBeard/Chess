<?php
namespace CodingBeard\Chess;

use Phalcon\Mvc\User\Component;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Websocket handler
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */
class Websocket extends Component implements MessageComponentInterface
{
    /**
     * Array of clients, keys are their player IDs
     * @var array
     */
    public $clients = [];

    /**
     * When a client Connects
     * @param ConnectionInterface $client
     */
    public function onOpen(ConnectionInterface $client)
    {

    }

    /**
     * When we receive a message
     * @param ConnectionInterface $client
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $client, $msg)
    {
        $json = json_decode($msg);
        if ($json) {
            if (!isset($client->playerId) && $json->action != 'connect') {
                $client->send(json_encode(['type' => 'alert', 'params' => [
                    'type' => 'error',
                    'body' => 'You must first auth before using any other functions.'
                ]]));
            }
            if (method_exists($this, $json->action)) {
                $client->send($this->{$json->action}($client, $json->params));
            }
        }
    }

    /**
     * When a client disconnects
     * @param ConnectionInterface $client
     */
    public function onClose(ConnectionInterface $client)
    {
        unset($this->clients[$client->playerId]);
        echo "Player ({$client->playerId}) has disconnected\n";
    }

    /**
     * When an error occurs
     * @param ConnectionInterface $client
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $client, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $client->close();
    }

    /**
     * On the initial connection set their player ID and add them to our clients
     * @param ConnectionInterface $client
     * @param $params
     * @return string
     */
    public function connect(ConnectionInterface $client, $params)
    {
        $client->playerId = $params->playerId;
        $this->clients[$params->playerId] = $client;
        echo "Player ({$client->playerId}) has connected\n";
        return json_encode(['type' => 'alert', 'params' => [
            'type' => 'log',
            'body' => 'Connected.'
        ]]);
    }
}
