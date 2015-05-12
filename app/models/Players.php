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
     * Initialize method for model.
     */
    public function initialize()
    {

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
            'token' => 'token'
        );
    }

}
