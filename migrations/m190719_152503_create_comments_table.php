<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%posts}}`
 */
class m190719_152503_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'message_text' => $this->string(150)->notNull(),
            'created_at' => $this->dateTime(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-comments-user_id}}',
            '{{%comments}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-comments-user_id}}',
            '{{%comments}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-comments-post_id}}',
            '{{%comments}}',
            'post_id'
        );

        // add foreign key for table `{{%posts}}`
        $this->addForeignKey(
            '{{%fk-comments-post_id}}',
            '{{%comments}}',
            'post_id',
            '{{%posts}}',
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
            '{{%fk-comments-user_id}}',
            '{{%comments}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-comments-user_id}}',
            '{{%comments}}'
        );

        // drops foreign key for table `{{%posts}}`
        $this->dropForeignKey(
            '{{%fk-comments-post_id}}',
            '{{%comments}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-comments-post_id}}',
            '{{%comments}}'
        );

        $this->dropTable('{{%comments}}');
    }
}
