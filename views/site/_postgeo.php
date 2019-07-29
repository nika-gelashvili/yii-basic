<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation_2 \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation_2, '[2]post_title')->textInput(['autofocus' => true])->label('სათაური') ?>

<?= $form->field($postTranslation_2, '[2]post_description')->textInput()->label('აღწერა') ?>

<?= $form->field($postTranslation_2, '[2]post_short_description')->textInput()->label('მოკლე აღწერა') ?>

<?= $form->field($postTranslation_2, '[2]locale')->hiddenInput(['value' => 'ka-GE'])->label(false) ?>
