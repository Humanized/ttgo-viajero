<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Supply */

$this->title = Yii::t('app', 'Offer Hosting');
?>
<div class="supply-create">

    <h2><?= Html::encode(Yii::t('app', 'Offer Hosting')) ?></h2>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
