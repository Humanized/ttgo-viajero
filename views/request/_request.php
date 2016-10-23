<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $model app\models\Request */
$form = null;
$respondBtn = !isset($data->response_date) ? Html::a(Yii::t('app', 'Respond'), ['respond', 'id' => $data->id], ['class' => 'btn btn-primary']) : "";
if ($asForm) {
    $form = ActiveForm::begin();
    $respondBtn = Html::submitButton(Yii::t('app', 'Respond'), ['class' => 'btn btn-primary']);
}
?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-xs-12">
        <?php
        if (!isset($data->response_date)) {
            ?>
            <span class="label label-primary">Pending</span>
            <?php
        } elseif ($data->isRejected()) {
            ?>
            <span class="label label-danger">Rejected</span> 
            <?php
        } else {
            ?>
            <span class="label label-success">Accepted</span>
            <span class="label label-warning">Partially</span> 
            <?php
        }
        ?>



    </div>
</div>
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
    $replied = isset($data->response_date);
    foreach ($data->accommodation as $date => $value) {
        if ($data->accommodation[$date]->request_count > 0) {
            ?>
            <div class="col-xs-6 col-md-1">
                <small><b><?= date("D", strtotime($date)); ?></br><?= date("d-m-Y", strtotime($date)); ?> </b></small><br>

                <?= $data->accommodation[$date]->request_count ?>
                <div class="pull-right"> <?= $replied ? ($data->accommodation[$date]->is_accepted ? '<i style="color:green;" class="glyphicon glyphicon-ok"></i>' : '<i style="color:red;" class="glyphicon glyphicon-remove"></i>') : '' ?></div>
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