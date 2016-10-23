<?php
/* @var $this yii\web\View */
//TODO: bugfix
/* @var $user common\models\User */
//TODO: Remove hardcode
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/default/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t('mail', 'salutation') ?>,
<?= Yii::t('mail', 'reset') ?>:
<?= $resetLink ?>
<?= Yii::t('mail', 'signature') ?>!
