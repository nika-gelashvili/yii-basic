<?php
/* @var $model app\models\Post */

use app\models\Post;
use yii\helpers\Html;

?>
<div style="padding: 5px">
    <div style="padding: 5px; overflow:auto; width:50%; font-size: 30px;font-style:normal">
        <?= HTML::encode($model->post_title) ?>
        <p style="float:right">
            <?php echo Html::img($model->post_image, ['width' => '150px', 'height' => '100px']) ?>
        </p>
    </div>
    <p>
        <?= Html::a('View', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
</div>