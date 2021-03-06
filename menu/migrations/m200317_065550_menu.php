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
            'image'     => $this->string(255),
            'type'      => $this->integer()->notNull(),
            'lft'       => $this->integer()->notNull(),
            'rgt'       => $this->integer()->notNull(),
            'menu'      => $this->integer()->notNull(),
            'tree'      => $this->integer(),
            'depth'     => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'status'    => $this->boolean()->notNull(),
            'target'    => $this->boolean()->notNull(),
            'render_js' => $this->boolean(),
            'access'    => $this->string(255)->defaultValue('everyone')
        ]);
        
        $this->createTable('{{%menu_item_content}}', [
            'id'           => $this->primaryKey(),
            'src_id' => $this->integer()->notNull(),
            'name'         => $this->string(255)->notNull(),
            'domain_id'    => $this->integer(),
            'language_id'  => $this->integer()
        ]);
        
        $this->addForeignKey('fk-menu_item-tree', '{{%menu_item}}', 'menu', '{{%menu}}', 'id', 'CASCADE');
        
        $this->addForeignKey('fk-mic-src_id', '{{%menu_item_content}}', 'src_id', '{{%menu_item}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-mic-domain_id', '{{%menu_item_content}}', 'domain_id', '{{%domain}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-mic-language_id', '{{%menu_item_content}}', 'language_id', '{{%language}}', 'id', 'CASCADE');
        
        $this->insert('{{%menu}}', [
            'name'  => 'top_menu',
            'title' => 'Top Menu',
        ]);
        $this->insert('{{%menu_item}}', [
            'data'      => null,
            'type'      => -1,
            'lft'       => 1,
            'rgt'       => 4,
            'tree'      => 1,
            'menu'      => 1,
            'depth'     => 0,
            'parent_id' => null,
            'status'    => 1,
            'target'    => 0,
            'render_js' => null,
            'access'    => 'everyone',
        ]);
        $this->insert('{{%menu_item}}', [
            'data'      => 1,
            'type'      => 2,
            'lft'       => 2,
            'rgt'       => 3,
            'menu'      => 1,
            'tree'      => 1,
            'depth'     => 1,
            'parent_id' => 1,
            'status'    => 1,
            'target'    => 0,
            'render_js' => 0,
            'access'    => 'everyone',
        ]);
        $this->insert('{{%menu_item_content}}', [
            'src_id' => 2,
            'name'         => 'Home page',
            'domain_id'    => null,
            'language_id'  => null
        ]);
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
