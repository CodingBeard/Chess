<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class EmailchangesMigration_100 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'emailchanges',
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
                    'user_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'authtoken_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'user_id'
                    )
                ),
                new Column(
                    'date',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'size' => 1,
                        'after' => 'authtoken_id'
                    )
                ),
                new Column(
                    'oldEmail',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 255,
                        'after' => 'date'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('user_id', array('user_id')),
                new Index('authtoken_id', array('authtoken_id'))
            ),
            'references' => array(
                new Reference('emailchanges_ibfk_1', array(
                    'referencedSchema' => 'beardsite',
                    'referencedTable' => 'users',
                    'columns' => array('user_id'),
                    'referencedColumns' => array('id')
                )),
                new Reference('emailchanges_ibfk_2', array(
                    'referencedSchema' => 'beardsite',
                    'referencedTable' => 'authtokens',
                    'columns' => array('authtoken_id'),
                    'referencedColumns' => array('id')
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '5',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
