<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Update Post: ' . $post->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->id, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('post', [
        'post' => $post,
    ]) ?>

</div>