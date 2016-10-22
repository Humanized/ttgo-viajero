<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$mode = ($searchModel->mode == app\models\RequestSearch::INBOX ? 'in' : 'out');

$fnRowOptions = function($model) {
    return ['style' => 'color:gray', 'class' => $model->is_new ? 'info' : ($model->isRejected() ? 'danger' : 'success')];
};

$fnAfterRow = function($model) {

    return '<tr><td colspan=100>' . $this->render('_request', ['data' => $model]) . '</td></tr>';
};

$this->title = ucwords(Yii::t('app', ($mode . ($mode == 'out' ? 'going' : 'coming') . ' Requests')));
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn', 'options' =>
        ['style' => 'width:50px;'],],
    ['attribute' => 'request_date', 'format' => 'datetime',
        'options' =>
        ['style' => 'width:100px;'],],
    //Show Inbox
    ['attribute' => 'user_id', 'label' => Yii::t('app', 'From'), 'value' => function($model) {
            return $model->user_id;
        }],
    //Show Outbox
    ['attribute' => 'user_id', 'label' => Yii::t('app', 'To'), 'value' => function($model) {
            return $model->supply->user_id;
        }],
    ['class' => 'yii\grid\ActionColumn', 'options' =>
        ['style' => 'width:100px;']],
];
?>

<h2><?= Html::encode($this->title) ?></h2>

<?php Pjax::begin(); ?>

<div class="row">
    <div class="col-sm-3">
        <?= $this->render('_search', ['model' => $searchModel]); ?>

    </div>

    <div class="col-sm-9">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //   'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'rowOptions' => $fnRowOptions,
            'afterRow' => $fnAfterRow,
            'columns' => $gridColumns,
                /*
                  [
                  'user_id',
                  ($mode == 'out' ? 'response' : 'request') . '_message:ntext',
                  //'request_message:ntext',
                  //'response_message:ntext',
                  ['class' => 'yii\grid\ActionColumn'],
                  ]
                 * ,
                 */
        ]);
        ?>

    </div>
</div>
<?php Pjax::end(); ?>