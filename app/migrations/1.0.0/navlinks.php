<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class NavlinksMigration_100 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'navlinks',
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
                    'navbar_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'level',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'navbar_id'
                    )
                ),
                new Column(
                    'label',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 255,
                        'after' => 'level'
                    )
                ),
                new Column(
                    'link',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 255,
                        'after' => 'label'
                    )
                ),
                new Column(
                    'parent_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'link'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('navbar_id', array('navbar_id')),
                new Index('parent_id', array('parent_id'))
            ),
            'references' => array(
                new Reference('navlinks_ibfk_1', array(
                    'referencedSchema' => 'beardsite',
                    'referencedTable' => 'navbars',
                    'columns' => array('navbar_id'),
                    'referencedColumns' => array('id')
                )),
                new Reference('navlinks_ibfk_2', array(
                    'referencedSchema' => 'beardsite',
                    'referencedTable' => 'navlinks',
                    'columns' => array('parent_id'),
                    'referencedColumns' => array('id')
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '38',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
