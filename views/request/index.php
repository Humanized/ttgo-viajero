<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$mode = ($searchModel->mode == app\models\RequestSearch::INBOX ? 'in' : 'out');

$fnRowOptions = function($model) {
    return ['style' => 'color:black', 'class' => $model->is_new ? 'label-info' : 'warning'];
};

$fnAfterRow = function($model) {
    return '<tr id="extra-row-' . $model->id . '" class="hidden"><td colspan=100>' . $this->render('_request', ['data' => $model, 'asForm' => false]) . '</td></tr>';
};


$this->title = ucwords(Yii::t('app', ($mode . ($mode == 'out' ? 'going' : 'coming') . ' Requests')));
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn', 'options' =>
        ['style' => 'width:50px;'],],
    ['attribute' => 'request_date', 'format' => 'datetime',
        'options' =>
        ['style' => 'width:100px;'],],
        /*
          ['attribute' => 'response_date',
          'label' => Yii::t('app', 'Status'), 'value' => function($model) {
          return $model->status;
          }],
         * 
         */
];

if ($mode == 'in') {

    $gridColumns[] = //Show Inbox
            ['attribute' => 'user_id', 'label' => Yii::t('app', 'From'), 'value' => function($model) {
                    return $model->user->username;
                }];
}if ($mode == 'out') {
    $gridColumns[] = //Show Outbox
            ['attribute' => 'user_id', 'label' => Yii::t('app', 'To'), 'value' => function($model) {
                    return $model->supply->user->username;
                }];
}
$gridColumns[] = ['class' => 'yii\grid\ActionColumn', 'template' => '{view}', 'buttons' => [

        //view button
        'view' => function ($url, $model) {
            $options = [
                'id' => 'request-' . $model->id,
                // 'visible' => (int) $model['status'] != 0 ? TRUE : FALSE,
                //'hidden' => (int) $model['status'] != 0 ? TRUE : FALSE,
                'title' => \Yii::t('yii', 'Open Request Message'),
                'aria-label' => \Yii::t('yii', 'Open Request Message'),
                'onclick' => 'var caller = this.id; toggle="#extra-row"+caller.replace("request",""); $(toggle).removeClass("hidden");',
            ];
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', null, $options);
        },
            ], 'options' =>
            ['style' => 'width:100px;']];
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