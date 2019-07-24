<?php

use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $comment \app\models\Comment */

$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->session->hasFlash('notAllowed')) : ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Error</h4>
            <?php Yii::$app->session->getFlash('notAllowed') ?>
        </div>
    <?php endif; ?>
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->getId() == $model->user_id): ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'post_description',

            [
                'attribute' => 'post_image',
                'value' => $model->post_image,
                'format' => ['image', ['width' => 200, 'height' => 'auto']]
            ]
        ],
    ]) ?>

    <?php echo \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_commentlist'
    ]) ?>

    <!-- GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'users.username',
            'message_text',
        ]
    ]) -->

    <?php $form = ActiveForm::begin([
        'id' => 'comment-form',
    ]); ?>
    <?= $form->field($comment, 'message_text')->textInput(['autofocus' => true])->label('Comment') ?>
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php else: ?>
        <div class="form-group">
            <?= Html::a('Sign in', ['login'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
</div>