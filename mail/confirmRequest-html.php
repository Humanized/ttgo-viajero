<?php

use yii\helpers\Html;
use app\models\RequestConfirmationMail;

/* @var $this yii\web\View */
//TODO: bugfix
/* @var $user common\models\User */
//TODO: Remove hardcode

$confirmLink = '';
$msg = '';
if ($mode == RequestConfirmationMail::INCOMING) {
    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/request/respond', 'id' => $request->id]);
    $msg = 'request_message';
}
if ($mode == RequestConfirmationMail::OUTGOING) {
    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/request/view', 'id' => $request->id]);
    $msg = 'respond_message';
}
?>
<div class="confirm-request">
    <p><?= Yii::t('mail', 'salutation') ?>,</p>
    <p><?= Yii::t('mail', 'request_' . $mode . '_body') ?>:</p>
    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
    <p><?= Yii::t('mail', 'The message was:') ?><br><i><?= $request->$msg ?></i></p>
    <p><?= Yii::t('mail', 'signature') ?></p>

</div>
