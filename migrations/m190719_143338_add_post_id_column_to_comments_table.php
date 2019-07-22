<?php

use yii\db\Migration;

/**
 * Handles adding post_id to table `{{%comments}}`.
 */
class m190719_143338_add_post_id_column_to_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%comments}}', 'post_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%comments}}', 'post_id');
    }
}
