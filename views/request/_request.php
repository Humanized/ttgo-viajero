<?php

use yii\bootstrap\Html;

/* @var $model app\models\Request */
?>

<div class="row">
    <div class="col-md-6">
        <h4>Request</h4>
        <p><?= $data->request_message ?></p>
    </div>
    <div class="col-md-6">

        <?php
        if (!isset($asForm)) {
            ?>
            <h4>Response</h4>
            <p><?= (isset($data->response_message) ? $data->response_message : Yii::t('app', 'No response submitted')) ?></p>
            <?php
        }
        ?>
    </div>
</div>

<div class="row">
    <?php
    foreach ($data->accommodation as $date => $value) {
        ?>
        <div class="col-xs-6 col-md-1">
            <b><?= date("D", strtotime($date)); ?></br><?= date("d-m-Y", strtotime($date)); ?> </b><br>

            <?= $data->accommodation[$date]->request_count ?>
        </div>

        <?php
    }
    ?>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::a(Yii::t('app', 'Respond'), ['respond', 'id' => $data->id], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
