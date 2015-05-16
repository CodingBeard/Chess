<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class FormdatasMigration_101 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'formdatas',
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
                    'formentry_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'field_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'formentry_id'
                    )
                ),
                new Column(
                    'value',
                    array(
                        'type' => Column::TYPE_TEXT,
                        'size' => 1,
                        'after' => 'field_id'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('formentry_id', array('formentry_id')),
                new Index('field_id', array('field_id'))
            ),
            'references' => array(
                new Reference('formdatas_ibfk_1', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'formentrys',
                    'columns' => array('formentry_id'),
                    'referencedColumns' => array('id')
                )),
                new Reference('formdatas_ibfk_2', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'formfields',
                    'columns' => array('field_id'),
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
