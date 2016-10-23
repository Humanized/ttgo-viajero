<?php

use yii\helpers\Html;
use app\models\Supply;

/* @var $this yii\web\View */
/* @var $model app\models\Request */

$this->title = Yii::t('app', 'Request Accommodation');
?>
<div class="request-create">

    <h2><?= Html::encode(Yii::t('app', 'Request Accommodation')) ?></h2>
   
    <p>
        <?=
        $this->render('/host/_view', [
            'model' => Supply::findOne($model->supplyId),
            'enableToolbar' => false,
        ])
        ?>
    </p>
    <div class="row">
        <?=
        $this->render('_create', [
            'model' => $model,
            'supply' => $supply,
        ])
        ?>
    </div>

</div>
