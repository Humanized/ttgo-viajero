<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Request */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-<?= isset($model->id) ? '6' : '12' ?>">
            <?= $form->field($model, !isset($model->id) ? 'request_message' : 'response_message')->textarea(['rows' => 6]) ?>
        </div>
    </div>


    <div class="row" style="height:35px;">
        <?php
        foreach ($model->accommodation as $date => $value) {
            ?>
            <div class="col-xs-4 col-md-1">
                <b><?= date("D", strtotime($date)); ?></br><?= date("d-m-Y", strtotime($date)); ?> </b><br>
                <?= $form->field($value, "[$date]" . "request_count")->label(false) ?>
                <?= $supply->accommodation[$date]->accommodation_count ?>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="row">
        <div class="col-xs-12 form-group" style="margin-top:10px;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send') : Yii::t('app', 'Respond'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
