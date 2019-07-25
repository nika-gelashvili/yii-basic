<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_translation}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%posts}}`
 */
class m190725_135716_create_post_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_translation}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'post_title' => $this->string(45)->notNull(),
            'post_description' => $this->string(300),
            'post_short_description' => $this->string(100),
            'locale' => $this->string()->notNull(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-post_translation-post_id}}',
            '{{%post_translation}}',
            'post_id'
        );

        // add foreign key for table `{{%posts}}`
        $this->addForeignKey(
            '{{%fk-post_translation-post_id}}',
            '{{%post_translation}}',
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
        // drops foreign key for table `{{%posts}}`
        $this->dropForeignKey(
            '{{%fk-post_translation-post_id}}',
            '{{%post_translation}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-post_translation-post_id}}',
            '{{%post_translation}}'
        );

        $this->dropTable('{{%post_translation}}');
    }
}
