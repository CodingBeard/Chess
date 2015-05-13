<?php

namespace models;

class Games extends \Phalcon\Mvc\Model
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
    public $type;

    /**
     *
     * @var integer
     */
    public $turn;

    /**
     *
     * @var integer
     */
    public $playerW_id;

    /**
     *
     * @var integer
     */
    public $playerB_id;

    /**
     *
     * @var \CodingBeard\Chess\Game
     */
    public $game;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'models\Moves', 'game_id', ['alias' => 'Moves']);
        $this->belongsTo('playerB_id', 'models\Players', 'id', ['alias' => 'Players']);
        $this->belongsTo('playerW_id', 'models\Players', 'id', ['alias' => 'Players']);
    }

    public function getSource()
    {
        return 'games';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'type' => 'type', 
            'turn' => 'turn', 
            'playerW_id' => 'playerW_id', 
            'playerB_id' => 'playerB_id'
        );
    }

}
