<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m190719_152237_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'post_title' => $this->string(45)->notNull(),
            'post_description' => $this->string(300),
            'post_image' => $this->string(30),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-posts-user_id}}',
            '{{%posts}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-posts-user_id}}',
            '{{%posts}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-posts-user_id}}',
            '{{%posts}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-posts-user_id}}',
            '{{%posts}}'
        );

        $this->dropTable('{{%posts}}');
    }
}
