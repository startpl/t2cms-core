<?php

use yii\db\Migration;

/**
 * Class m200317_065550_menu
 */
class m200317_065550_menu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(120)->notNull()->unique(),
            'title'      => $this->string(120)->notNull()
        ]);
        
        $this->createTable('{{%menu_item}}', [
            'id'        => $this->primaryKey(),
            'name'      => $this->string(255)->notNull(),
            'data'      => $this->string(255),
            'type'      => $this->integer()->notNull(),
            'lft'       => $this->integer()->notNull(),
            'rgt'       => $this->integer()->notNull(),
            'tree'      => $this->integer()->notNull(),
            'depth'     => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'status'    => $this->boolean()->notNull(),
            'target'    => $this->boolean()->notNull()
        ]);
        
        $this->addForeignKey('fk-menu_item-tree', '{{%menu_item}}', 'tree', '{{%menu}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200317_065550_menu cannot be reverted.\n";

        return false;
    }
}
