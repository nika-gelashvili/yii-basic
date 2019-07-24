<?php

/* @var $model \app\models\Comment */


use app\models\Comment;
use yii\helpers\Html;

?>

<div style="min-height: 50px; padding-top: 5px; padding-left: 10px;margin-bottom: 5px">
    <p style="font-size: large">
        <?php echo Html::encode($model->message_text) ?>
    </p>
    <p style="font-size:x-small">
        <?php echo Html::encode('User: ' . $model->users->username) ?>
    </p>
</div>
