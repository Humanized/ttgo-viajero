<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Supply */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supply-form">

    <?php $form = ActiveForm::begin(); ?>


    <h3>General Description</h3>
    <div class="col-xs-12 col-md-2">
        <div class="row">
            <div class="col-xs-4 col-md-12">
                <?= $form->field($model, 'has_wifi')->widget(SwitchInput::classname(), []); ?>
            </div>
            <div class="col-xs-4 col-md-12">
                <?= $form->field($model, 'has_kitchen')->widget(SwitchInput::classname(), []); ?>
            </div>
            <div class="col-xs-4 col-md-12">
                <?= $form->field($model, 'has_shower')->widget(SwitchInput::classname(), []); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-5">
        <?= $form->field($model, 'description_public')->textarea(['rows' => 8]) ?>

    </div>
    <div class="col-xs-12 col-md-5">
        <?= $form->field($model, 'description_private')->textarea(['rows' => 8]) ?>

    </div>
</div>
<h3>Available Accommodation</h3>
<div class="row">
    <?php
    foreach ($model->accommodation as $date => $value) {
        ?>

        <div class="col-xs-4 col-md-1">
            <b><?= date("D", strtotime($date)); ?></br><?= date("d-m-Y", strtotime($date)); ?> </b><br>
            <?= $form->field($value, "[$date]accommodation_count")->label(false) ?>
        </div>

        <?php
    }
    ?>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
