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
            [['post_image'],'file','extensions' => 'png,jpg,gif,jpeg','skipOnEmpty'=>false],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'id' => 'id',
            'post_image'=>'Thumbnail'
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
    public function getPostTranslation(){
        return $this->hasMany(PostTranslation::className(),['post_id'=>'id']);
    }
}