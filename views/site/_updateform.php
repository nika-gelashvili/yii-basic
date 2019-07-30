<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $postTranslation app\models\PostTranslation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-translation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($postTranslation, 'post_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($postTranslation, 'post_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($postTranslation, 'post_short_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($postTranslation,'locale')->hiddenInput(['value'=>$postTranslation->locale])->label(false)?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>