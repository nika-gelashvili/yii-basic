<?php

use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\PostTranslation */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $postDataProvider ActiveDataProvider */
/* @var $comment \app\models\Comment */

$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">
    <?php if (Yii::$app->session->hasFlash('notAllowed')) : ?>
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Error</h4>
            <?php Yii::$app->session->getFlash('notAllowed') ?>
        </div>
    <?php endif; ?>
    <?php if (!Yii::$app->user->isGuest && isset($model->post->user_id) && Yii::$app->user->identity->getId() == $model->post->user_id): ?>
        <?= Html::a('Update', ['update', 'id' => $model->post_id,'lang'=>$model->locale], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->post_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>

    <?php echo ListView::widget([
        'dataProvider' => $postDataProvider,
        'itemView' => '_postview',
        'summary' => ''
    ]) ?>

    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_commentlist',
        'summary' => ''
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