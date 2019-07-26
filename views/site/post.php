<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $post \app\models\Post */
/* @var $postTranslation \app\models\PostTranslation */

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

    <?= $form->field($postTranslation, 'post_title')->textInput(['autofocus' => true])->label('Title') ?>

    <?= $form->field($postTranslation, 'post_description')->textInput()->label('Description') ?>

    <?= $form->field($postTranslation, 'post_short_description')->textInput()->label('Description') ?>

    <?= $form->field($post, 'post_image')->fileInput(['accept' => 'image/*'])->label('Thumbnail') ?>

    <?= $form->field($upload, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Post Images') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>