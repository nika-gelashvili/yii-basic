<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_translation".
 *
 * @property int $id
 * @property int $post_id
 * @property string $post_title
 * @property string $post_description
 * @property string $post_short_description
 * @property string $locale
 *
 * @property Post $post
 */
class PostTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{post_translation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'post_title', 'locale'], 'required'],
            [['post_id'], 'integer'],
            [['post_title'], 'string', 'max' => 45],
            [['post_description'], 'string', 'max' => 300],
            [['post_short_description'], 'string', 'max' => 100],
            [['locale'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'post_title' => 'Post Title',
            'post_description' => 'Post Description',
            'post_short_description' => 'Post Short Description',
            'locale' => 'Locale',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}