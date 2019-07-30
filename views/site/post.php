<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $post \app\models\Post */
/* @var $postTranslation_eng \app\models\PostTranslation */
/* @var $postTranslation_geo \app\models\PostTranslation */
/* @var $postTranslation_rus \app\models\PostTranslation */

/* @var $upload \app\models\Image */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'post-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
    ]); ?>

    <?= \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'English',
                'content' => $this->render('_posteng', ['postTranslation' => $postTranslation_eng, 'form' => $form]),
                'active' => true,
                'id'
            ],
            [
                'label' => 'ქართული',
                'content' => $this->render('_postgeo', ['postTranslation' => $postTranslation_geo, 'form' => $form]),
            ],
            [
                'label' => 'Русский',
                'content' => $this->render('_postrus', ['postTranslation' => $postTranslation_rus, 'form' => $form]),
            ]
        ]
    ]) ?>


    <?= $form->field($post, 'post_image')->fileInput(['accept' => 'image/*'])->label('Thumbnail') ?>

    <?= $form->field($upload, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Post Images') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>