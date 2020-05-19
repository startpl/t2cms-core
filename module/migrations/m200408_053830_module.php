<?php

use yii\db\Migration;

/**
 * Class m200408_053830_module
 */
class m200408_053830_module extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%module}}', [
            'path'         => $this->string(255)->notNull(),
            'url'          => $this->string(100)->notNull(),
            'version'      => $this->string(20),
            'status'       => $this->smallInteger(2),
            'show_in_menu' => $this->boolean(),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
            'PRIMARY KEY ([[path]])'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%module}}');

        return true;
    }
}
