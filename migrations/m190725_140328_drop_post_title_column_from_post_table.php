<?php

use yii\db\Migration;

/**
 * Handles dropping post_title from table `{{%post}}`.
 */
class m190725_140328_drop_post_title_column_from_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%posts}}', 'post_title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%posts}}', 'post_title', $this->string(45));
    }
}
