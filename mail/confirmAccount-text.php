<?php
/* @var $this yii\web\View */
//TODO: bugfix
/* @var $user common\models\User */
//TODO: Remove hardcode
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/account/confirm', 'token' => $user->password_reset_token]);
?>

<?= Yii::t('mail', 'salutation') ?>,
<?= Yii::t('mail', 'confirmation') ?>:
<?= $confirmLink ?>
<?= Yii::t('mail', 'signature')?>!