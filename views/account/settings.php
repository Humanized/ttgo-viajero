<?php

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Personal Settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Yii::$app->session->getFlash('ok'); ?>
<?php Pjax::begin(); ?>

<?= $this->render('_settings', ['model' => $model]) ?>

<?php Pjax::end(); ?>