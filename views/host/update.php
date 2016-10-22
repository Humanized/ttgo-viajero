<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Supply */

$this->title = Yii::t('app', 'Update My Offer') . ' - TTIP GAME OVER';
?>
<div class="supply-update">

    <h2><?= Html::encode(Yii::t('app', 'Update My Offer')) ?></h2>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
