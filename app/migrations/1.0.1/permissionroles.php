<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class PermissionrolesMigration_101 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'permissionroles',
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
                    'permission_id',
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
                        'after' => 'permission_id'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('permission_id', array('permission_id')),
                new Index('role_id', array('role_id'))
            ),
            'references' => array(
                new Reference('permissionroles_ibfk_1', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'permissions',
                    'columns' => array('permission_id'),
                    'referencedColumns' => array('id')
                )),
                new Reference('permissionroles_ibfk_2', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'roles',
                    'columns' => array('role_id'),
                    'referencedColumns' => array('id')
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '16',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
