<div class="row"  style="background:whitesmoke;border:2px solid lightslategray; border-bottom:0px;height:100%;">
<h5><?= Yii::t('app', 'Provisions')?></h5>

    <div class="row"style="font-size: 0.9em;background:whitesmoke; color:black;border:2px solid lightslategray;border-bottom:0px;">
        <?php
        foreach ($model->accommodation as $date => $value) {
            ?>
            <div class="col-xs-4 col-md-1"style="border-right:2px solid lightslategray;">
                <b><?= Yii::$app->formatter->asDate(strtotime($date), 'EEE<br> dd-MM-yy'); ?></b><br>
                <?= $value->accommodation_count ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="col-md-2" style="height:100%;font-weight: bolder;padding:5px; color:black">
        <h5><?= Yii::t('app', 'Provisions'); ?></h5>
        <?php
        $none = true;
        ?>
        <p><?= ($model->has_wifi == 0 ? '' : Yii::t('app', 'Wifi available')) ?></p>
        <p><?= ($model->has_kitchen == 0 ? '' : Yii::t('app', 'Kitchen available')); ?></p>
        <p><?= ($model->has_shower == 0 ? '' : Yii::t('app', 'Shower available')); ?></p>
        <p><?= ($model->has_shower == 0 && $model->has_kitchen == 0 && $model->has_wifi == 0 ? Yii::t('app', 'No Provisions Available') : ''); ?></p>
    </div>


    <div class="col-md-offset-1 col-md-9" style="padding-top:5px;" >
        <h5 style="color:black;"><?= Yii::t('app', 'Description'); ?></h5>
        <p style="color:lightslategray;border: lightblue solid 1px;padding:10px;"><?= $model->description_public; ?></p>
    </div>
    <div class="row"style="color:black;background:whitesmoke; border:2px solid lightslategray; border-top:0px;padding-top: 10px;padding-right: 10px;margin-bottom: 20px; ">

        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Request Accommodation'), ['request/send', 'id' => $model->id], ['class' => "btn btn-md btn-success"]) ?>
            <?= $model->user_id == Yii::$app->user->id ? Html::a(Yii::t('app', 'Update Offer'), ['host/update', 'id' => $model->id], ['class' => "btn btn-md btn-warning"]) : '' ?>
            <?=
            $model->user_id == Yii::$app->user->id ? Html::a(Yii::t('app', 'Remove Offer'), ['host/delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                ]]) : ''
            ?>
        </p>
    </div>

</div>
