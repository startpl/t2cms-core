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
        
        $this->createTable('{{%menu_item_content}}', [
            'id'           => $this->primaryKey(),
            'menu_item_id' => $this->integer()->notNull(),
            'name'         => $this->string(255)->notNull(),
            'domain_id'    => $this->integer(),
            'language_id'  => $this->integer()
        ]);
        
        $this->addForeignKey('fk-menu_item-tree', '{{%menu_item}}', 'tree', '{{%menu}}', 'id', 'CASCADE');
        
        $this->addForeignKey('fk-mic-item-id', '{{%menu_item_content}}', 'menu_item_id', '{{%menu_item}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-mic-domain_id', '{{%menu_item_content}}', 'domain_id', '{{%domain}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-mic-language_id', '{{%menu_item_content}}', 'language_id', '{{%language}}', 'id', 'CASCADE');
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
