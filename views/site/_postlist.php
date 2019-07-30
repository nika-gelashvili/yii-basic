<?php
/* @var $model app\models\PostTranslation */
use app\models\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;

?>
<div style="padding: 5px;position: relative;font-size: 30px;font-style:normal;">
    <?= HTML::encode($model->post_title) ?>
    <div style="padding: 5px; overflow:auto; width:50%;">
        <p style="float:left; margin-right: 15px;">
            <?php
//            var_dump($model->post->post_image);
//            exit;
                echo Html::img('uploads/'.$model->post->post_image, ['width' => '150px', 'height' => '100px']);
            ?>
        </p>
        <p style="font-size: medium">
            <?php echo StringHelper::truncateWords(Html::encode($model->post_short_description), 5) ?>
        </p>
        <p>
            <?= Html::a('View', ['view', 'id' => $model->post->id,'lang'=>$model->locale], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>
</div>