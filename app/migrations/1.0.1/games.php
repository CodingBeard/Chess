<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class GamesMigration_101 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'games',
            array(
            'columns' => array(
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 11,
                        'first' => true
                    )
                ),
                new Column(
                    'type',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 50,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'turn',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'type'
                    )
                ),
                new Column(
                    'playerW_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'turn'
                    )
                ),
                new Column(
                    'playerB_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'playerW_id'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('playerW_id', array('playerW_id')),
                new Index('playerB_id', array('playerB_id'))
            ),
            'references' => array(
                new Reference('games_ibfk_2', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'players',
                    'columns' => array('playerB_id'),
                    'referencedColumns' => array('id')
                )),
                new Reference('games_ibfk_1', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'players',
                    'columns' => array('playerW_id'),
                    'referencedColumns' => array('id')
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '73',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
