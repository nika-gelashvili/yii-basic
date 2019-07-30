<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation, '[rus]post_title')->textInput(['autofocus' => true])->label('Заголовок') ?>

<?= $form->field($postTranslation, '[rus]post_description')->textInput()->label('Описание') ?>

<?= $form->field($postTranslation, '[rus]post_short_description')->textInput()->label('Короткое Описание') ?>

<?= $form->field($postTranslation, '[rus]locale')->hiddenInput(['value' => 'ru-RU'])->label(false) ?>
