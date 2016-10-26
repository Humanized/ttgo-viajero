<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Authentication');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Yii::$app->session->getFlash('ok'); ?>

<?php Pjax::begin(); ?>

<div class="row"  style="border:1px solid #fff">
    <div class="col-md-6" style="border-right:1px solid #fff">
        <h2><?= Html::encode(Yii::t('app', 'Sign In')) ?></h2>
        <?= $this->render('_login', ['model' => $login]) ?>

    </div>

    <div class="col-md-6">
        <h2><?= Html::encode(Yii::t('app', 'Sign Up')) ?></h2>
        <?= $this->render('_signup', ['model' => $signup]) ?>

    </div>
</div>
<?php Pjax::end(); ?>