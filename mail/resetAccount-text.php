<?php
/* @var $this yii\web\View */
//TODO: bugfix
/* @var $user common\models\User */
//TODO: Remove hardcode
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/account/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t('mail', 'salutation') ?>,
<?= Yii::t('mail', 'reset_body') ?>:
<?= $resetLink ?>
<?= Yii::t('mail', 'signature') ?>!
