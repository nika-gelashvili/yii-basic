<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */

/* @var $postTranslation_1 \app\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation_1, '[1]post_title')->textInput(['autofocus' => true])->label('Title') ?>

<?= $form->field($postTranslation_1, '[1]post_description')->textInput()->label('Description') ?>

<?= $form->field($postTranslation_1, '[1]post_short_description')->textInput()->label('Short Description') ?>

<?= $form->field($postTranslation_1, '[1]locale')->hiddenInput(['value' => 'en-US'])->label(false) ?>
