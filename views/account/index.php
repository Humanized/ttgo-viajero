<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Account Verification') . ' - TTIP GAME OVER';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php Pjax::begin(); ?>

<div class="row"  style="border:1px solid #fff">
    <div class="col-md-6" style="border-right:1px solid #fff">
        <h2><?= Html::encode(Yii::t('app', 'Login with Existing Account')) ?></h2>
        <?= $this->render('@vendor/humanized/yii2-advanced-application-template-user/views/default/login', ['model' => $login]) ?>

    </div>

    <div class="col-md-6">
        <h2><?= Html::encode(Yii::t('app', 'Register a New Account')) ?></h2>
        <?= $this->render('_registrationform', ['model' => $signup]) ?>

    </div>
</div>
<?php Pjax::end(); ?>