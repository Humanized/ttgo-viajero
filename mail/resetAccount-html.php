<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
//TODO: bugfix
/* @var $user common\models\User */
//TODO: Remove hardcode
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/account/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?= Yii::t('mail', 'salutation') ?>,</p>
    <p><?= Yii::t('mail', 'reset_body') ?>:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    <p><?= Yii::t('mail', 'signature') ?></p>
</div>
