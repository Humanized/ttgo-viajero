<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Find Hosting') . '- TTIP GAME OVER';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supply-index">

    <h1><?= Html::encode('Find Hosting') ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        More text to come..
    </p>

    <div class="row">
        <div class="col-sm-3">
        </div>

        <div class="col-sm-9">
            <?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
                'viewParams'=>['enableToolbar'=>true],
                //   'filterModel' => $searchModel,
                'options' => [
                    'tag' => 'div',
                    'class' => 'list-wrapper',
                    'id' => 'list-wrapper',
                ],
            ]);
            ?>
        </div>
    </div>

    <?php Pjax::end(); ?>
</div>
