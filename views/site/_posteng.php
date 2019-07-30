<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation_eng \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation_eng, '[eng]post_title')->textInput(['autofocus' => true])->label('Title') ?>

<?= $form->field($postTranslation_eng, '[eng]post_description')->textInput()->label('Description') ?>

<?= $form->field($postTranslation_eng, '[eng]post_short_description')->textInput()->label('Short Description') ?>

<?= $form->field($postTranslation_eng, '[eng]locale')->hiddenInput(['value' => 'en-US'])->label(false) ?>
