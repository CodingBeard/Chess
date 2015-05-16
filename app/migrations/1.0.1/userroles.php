<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class UserrolesMigration_101 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'userroles',
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
                    'role_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'user_id'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('user_id', array('user_id')),
                new Index('role_id', array('role_id'))
            ),
            'references' => array(
                new Reference('userroles_ibfk_1', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'users',
                    'columns' => array('user_id'),
                    'referencedColumns' => array('id')
                )),
                new Reference('userroles_ibfk_2', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'roles',
                    'columns' => array('role_id'),
                    'referencedColumns' => array('id')
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '3',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
