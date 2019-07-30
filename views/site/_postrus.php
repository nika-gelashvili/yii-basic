<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation_rus \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation_rus, '[rus]post_title')->textInput(['autofocus' => true])->label('Заголовок') ?>

<?= $form->field($postTranslation_rus, '[rus]post_description')->textInput()->label('Описание') ?>

<?= $form->field($postTranslation_rus, '[rus]post_short_description')->textInput()->label('Короткое Описание') ?>

<?= $form->field($postTranslation_rus, '[rus]locale')->hiddenInput(['value' => 'ru-RU'])->label(false) ?>
