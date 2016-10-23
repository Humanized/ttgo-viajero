<?php
/* @var $this yii\web\View */
//TODO: bugfix
/* @var $user common\models\User */
//TODO: Remove hardcode
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/default/reset-password', 'token' => $user->password_reset_token]);
$resetLink = str_replace('api', 'gui', $resetLink);
?>
Dear Pulsar Client,

Follow the link below to <?= $user->status != 0 ? 're' : '' ?>set your password:

<?= $resetLink ?>
