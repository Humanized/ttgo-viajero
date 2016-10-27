<?php
/* @var $this yii\web\View */
//TODO: bugfix
/* @var $user common\models\User */
//TODO: Remove hardcode
use app\models\RequestConfirmationMail;

$confirmLink = '';
if ($mode == RequestConfirmationMail::INCOMING) {
    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/request/respond', 'id' => $request->id]);
    $msg = 'request_message';
}
if ($mode == RequestConfirmationMail::OUTGOING) {
    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/request/view', 'id' => $request->id]);
    $msg = 'respond_message';
}
?>?>

<?= Yii::t('mail', 'salutation') ?>,
<?= Yii::t('mail', 'request_' . $mode . '_body') ?>
<?= $confirmLink ?>
<?= Yii::t('mail', 'The message was:') ?> <?= $request->$msg ?>
<?= Yii::t('mail', 'signature') ?>!