<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $postTranslation app\models\PostTranslation */
/* @var $upload app\models\Image */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Update Post: ' . $postTranslation->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $postTranslation->post_id, 'url' => ['view', 'id' => $postTranslation->post_id, 'lang' => $postTranslation->locale]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        echo $this->render('_updateform', [
            'postTranslation' => $postTranslation,
        ]);
    ?>

</div>