<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/** @var \app\models\Post $post */

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

    <?= $form->field($post, 'post_title')->textInput(['autofocus' => true])->label('Title') ?>

    <?= $form->field($post, 'post_description')->textInput()->label('Description') ?>


    <?= $form->field($post, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>