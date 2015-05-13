<?php

namespace models;

class Moves extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $game_id;

    /**
     *
     * @var integer
     */
    public $fromX;

    /**
     *
     * @var integer
     */
    public $fromY;

    /**
     *
     * @var integer
     */
    public $toX;

    /**
     *
     * @var integer
     */
    public $toY;

    /**
     *
     * @var string
     */
    public $fromPiece;

    /**
     *
     * @var string
     */
    public $toPiece;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('game_id', 'models\Games', 'id', ['alias' => 'Games']);
    }

    public function getSource()
    {
        return 'moves';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'game_id' => 'game_id', 
            'fromX' => 'fromX', 
            'fromY' => 'fromY', 
            'toX' => 'toX', 
            'toY' => 'toY', 
            'fromPiece' => 'fromPiece', 
            'toPiece' => 'toPiece'
        );
    }

}
