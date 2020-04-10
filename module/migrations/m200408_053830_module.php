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
            'id'         => $this->primaryKey(),
            'url'        => $this->string(100)->notNull(),
            'path'       => $this->string(255)->notNull(),
            'version'    => $this->string(20),
            'status'     => $this->smallInteger(2),
            'settings'   => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
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
