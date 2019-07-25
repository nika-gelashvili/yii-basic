<?php


namespace app\models;


use yii\db\ActiveRecord;

class Post extends ActiveRecord
{
    //public $file;

    public static function tableName()
    {
        return '{{posts}}';
    }

    public function rules()
    {
        return [
            [['post_title', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['post_title'], 'string', 'max' => 45],
            [['post_description'], 'string', 'max' => 300],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => \Yii::t('app', 'User ID'),
            'id' => \Yii::t('app', 'id'),
            'post_title' => \Yii::t('app', 'Title of Post'),
            'post_description' => \Yii::t('app', 'Text'),
            'file' => \Yii::t('app', 'Post Image')
        ];
    }

    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['post_id' => 'id']);
    }
}