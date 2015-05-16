<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class MovesMigration_101 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'moves',
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
                    'game_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'fromX',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'game_id'
                    )
                ),
                new Column(
                    'fromY',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'fromX'
                    )
                ),
                new Column(
                    'toX',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'fromY'
                    )
                ),
                new Column(
                    'toY',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'toX'
                    )
                ),
                new Column(
                    'fromPiece',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 50,
                        'after' => 'toY'
                    )
                ),
                new Column(
                    'toPiece',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 50,
                        'after' => 'fromPiece'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('game_id', array('game_id'))
            ),
            'references' => array(
                new Reference('moves_ibfk_1', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'games',
                    'columns' => array('game_id'),
                    'referencedColumns' => array('id')
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '1',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
