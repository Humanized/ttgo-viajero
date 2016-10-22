<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $model app\models\Request */
$form = null;
$respondBtn = Html::a(Yii::t('app', 'Respond'), ['respond', 'id' => $data->id], ['class' => 'btn btn-primary']);
if ($asForm) {
    $form = ActiveForm::begin();
    $respondBtn = Html::submitButton(Yii::t('app', 'Respond'), ['class' => 'btn btn-primary']);
}
?>

<div class="row">
    <div class="col-md-6">
        <b>Request</b>
        <p><?= $data->request_message ?></p>
    </div>
    <div class="col-md-6">
        <b>Response</b>
        <?php
        if ($asForm) {
            ?>
            <p>  <?= $form->field($data, 'response_message')->textarea(['rows' => 8])->label(false) ?></p>
            <?php
        }

        if (!$asForm) {
            ?>
            <p><?= (isset($data->response_message) ? $data->response_message : Yii::t('app', 'No response submitted')) ?></p>
            <?php
        }
        ?>
    </div>
</div>
<p><b>Accommodation Requested</b></p>
<div class="row">

    <?php
    foreach ($data->accommodation as $date => $value) {
        if ($data->accommodation[$date]->request_count > 0) {
            ?>
            <div class="col-xs-6 col-md-1">
                <b><?= date("D", strtotime($date)); ?></br><?= date("d-m-Y", strtotime($date)); ?> </b><br>

                <?= $data->accommodation[$date]->request_count ?>

                <?=
                $asForm ? $form->field($value, "[$date]" . "is_accepted")->widget(SwitchInput::classname(), [ 'pluginOptions' => [
                                //    'labelText' => '<i class="glyphicon glyphicon-stop"></i>',
                                'onText' => '<i class="glyphicon glyphicon-ok"></i>',
                                'offText' => '<i class="glyphicon glyphicon-remove"></i>'
                    ]]) : ''
                ?>
            </div>

            <?php
        }
    }
    ?>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="pull-right">
            <?= $respondBtn ?>
        </div>
    </div>
</div>
<?php
if ($asForm) {
    ActiveForm::end();
}
?>