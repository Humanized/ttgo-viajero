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

    <h4><?= Yii::t('app', 'Description'); ?></h4>

    <div class="row">

        <div class="col-xs-12 col-md-2">
            <div class="row">
                <div class="col-xs-4 col-md-12">
                    <?=
                    $form->field($model, 'has_wifi')->widget(SwitchInput::classname(), [ 'pluginOptions' => [
                            //    'labelText' => '<i class="glyphicon glyphicon-stop"></i>',
                            'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                            'offText' => '<i class="glyphicon glyphicon-remove"></i>'
                    ]]);
                    ?>
                </div>
                <div class="col-xs-4 col-md-12">
                    <?=
                    $form->field($model, 'has_kitchen')->widget(SwitchInput::classname(), [ 'pluginOptions' => [
                            //    'labelText' => '<i class="glyphicon glyphicon-stop"></i>',
                            'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                            'offText' => '<i class="glyphicon glyphicon-remove"></i>'
                    ]]);
                    ?>
                </div>
                <div class="col-xs-4 col-md-12">
                    <?=
                    $form->field($model, 'has_shower')->widget(SwitchInput::classname(), [ 'pluginOptions' => [
                            //    'labelText' => '<i class="glyphicon glyphicon-stop"></i>',
                            'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                            'offText' => '<i class="glyphicon glyphicon-remove"></i>'
                    ]]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-5">
            <?= $form->field($model, 'description_public')->textarea([
                    'rows' => 8,
                    'placeHolder' => Yii::t('app', 'host.description_public.placeholder')
                ]) ?>

        </div>
        <div class="col-xs-12 col-md-5">
            <?= $form->field($model, 'description_private')->textarea([
                    'rows' => 8,
                    'placeHolder' => Yii::t('app', 'host.description_private.placeholder')
                ]) ?>
        </div>
    </div>
    <h3><?= Yii::t('app', 'Accommodation Provided'); ?></h3>
    <div class="row">

        <?php
        foreach ($model->accommodation as $date => $value) {
            ?>

            <div class="col-xs-4 col-md-1">
                <b><?= Yii::$app->formatter->asDate(strtotime($date), 'EEE dd-MM-yy'); ?></b><br>
                <?= $form->field($value, "[$date]accommodation_count")->label(false)?>
            </div>

            <?php
        }
        ?>
    </div>
    <div class="row">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

