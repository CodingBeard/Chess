<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class ContentsMigration_101 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'contents',
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
                    'ordering',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'width',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'ordering'
                    )
                ),
                new Column(
                    'offset',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 4,
                        'after' => 'width'
                    )
                ),
                new Column(
                    'content',
                    array(
                        'type' => Column::TYPE_TEXT,
                        'size' => 1,
                        'after' => 'offset'
                    )
                ),
                new Column(
                    'page_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'content'
                    )
                ),
                new Column(
                    'parent_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 11,
                        'after' => 'page_id'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('page_id', array('page_id')),
                new Index('parent_id', array('parent_id'))
            ),
            'references' => array(
                new Reference('contents_ibfk_1', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'pages',
                    'columns' => array('page_id'),
                    'referencedColumns' => array('id')
                )),
                new Reference('contents_ibfk_2', array(
                    'referencedSchema' => 'chess',
                    'referencedTable' => 'contents',
                    'columns' => array('parent_id'),
                    'referencedColumns' => array('id')
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '4',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
