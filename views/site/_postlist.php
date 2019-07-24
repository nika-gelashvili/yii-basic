<?php
/* @var $model app\models\Post */

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;

?>
<div style="padding: 5px;position: relative">
    <div style="padding: 5px; overflow:auto; width:50%; font-size: 30px;font-style:normal;">
        <?= HTML::encode($model->post_title) ?>
        <p style="font-size: medium">
            <?php echo StringHelper::truncateWords(Html::encode($model->post_description), 5) ?>
        </p>
        <p style="float:right;">
            <?php echo Html::img($model->post_image, ['width' => '150px', 'height' => '100px']) ?>
        </p>
    </div>
    <p>
        <?= Html::a('View', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
</div>