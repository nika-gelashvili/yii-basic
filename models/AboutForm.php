<?php


namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class AboutForm extends ActiveRecord
{
    public $imageFile;

    public function rules()
    {
        return [
            ['title','string','max'=>45],
            ['description','string','max'=>300],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}