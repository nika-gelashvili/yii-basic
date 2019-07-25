<?php
/* @var $model \app\models\Post */
?>
<div style="margin-top: 20px;margin-bottom: 30px;">
    <div>
        <h1><?= \yii\helpers\Html::encode($model->post_title) ?></h1>
        <p>
            <?= $model->post_description ?>
        </p>
        <p>
            <?php
            $images = [];
            foreach ($model->images as $imageItem) {
                $images[] = '<img src="' . 'uploads/' . $imageItem->image . '"/>';
            }
            echo \yii\bootstrap\Carousel::widget([
                'items' => $images,
                'options' => [
                    'style' => [
                        'width'=>'350px',
                        'height'=>'150px',
                    ]
                ]
            ]) ?>
        </p>
    </div>
</div>
