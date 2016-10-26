<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="site-login">

    <p><?= Yii::t("app", "Please fill out the following fields to login") ?></p>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        <?= Html::a('Forgot Password', ['/account/request-account-reset'], ['class' => 'btn btn-warning', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
