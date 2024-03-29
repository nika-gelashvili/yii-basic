<?php

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\Post;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Posts';

?>


<?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>Error</h4>
        <?php return Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
<p style="margin-bottom: 25px; margin-top: 20px;">
    <?php echo HTML::a('Create Post', ['post'], ['class' => 'btn btn-primary']) ?>
</p>
<!--
echo GridView::widget([
'dataProvider' => $dataProvider,
'columns' => [
    ['class' => 'yii\grid\SerialColumn'],
    'post_title',
    'post_description',
    'post_image',
    'user_id',
    ['class' => 'yii\grid\ActionColumn'],
]
])
*/
-->
<?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_postlist'
])
?>
