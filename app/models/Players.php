<?php

namespace models;

class Players extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $token;

    /**
     *
     * @var string
     */
    public $name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'models\Game', 'playerB_id', ['alias' => 'Game']);
        $this->hasMany('id', 'models\Game', 'playerW_id', ['alias' => 'Game']);
    }

    public function getSource()
    {
        return 'players';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'token' => 'token', 
            'name' => 'name'
        );
    }

}
