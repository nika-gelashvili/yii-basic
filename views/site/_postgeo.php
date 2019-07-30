<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation_geo \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation_geo, '[geo]post_title')->textInput(['autofocus' => true])->label('სათაური') ?>

<?= $form->field($postTranslation_geo, '[geo]post_description')->textInput()->label('აღწერა') ?>

<?= $form->field($postTranslation_geo, '[geo]post_short_description')->textInput()->label('მოკლე აღწერა') ?>

<?= $form->field($postTranslation_geo, '[geo]locale')->hiddenInput(['value' => 'ka-GE'])->label(false) ?>
