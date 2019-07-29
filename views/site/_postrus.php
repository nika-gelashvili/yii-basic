<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation_3 \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation_3, '[3]post_title')->textInput(['autofocus' => true])->label('Заголовок') ?>

<?= $form->field($postTranslation_3, '[3]post_description')->textInput()->label('Описание') ?>

<?= $form->field($postTranslation_3, '[3]post_short_description')->textInput()->label('Короткое Описание') ?>

<?= $form->field($postTranslation_3, '[3]locale')->hiddenInput(['value' => 'ru-RU'])->label(false) ?>
