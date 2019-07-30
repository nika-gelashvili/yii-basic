<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation, '[eng]post_title')->textInput(['autofocus' => true])->label('Title') ?>

<?= $form->field($postTranslation, '[eng]post_description')->textInput()->label('Description') ?>

<?= $form->field($postTranslation, '[eng]post_short_description')->textInput()->label('Short Description') ?>

<?= $form->field($postTranslation, '[eng]locale')->hiddenInput(['value' => 'en-US'])->label(false) ?>
