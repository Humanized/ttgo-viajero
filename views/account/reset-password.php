<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin(['id' => 'form-settings']);
?>


<div class="form-group">
    <?=
    $this->render('_reset-password', [
        'form' => $form,
        'model' => $model,
    ]);
    ?>
    <?= Html::submitButton(Yii::t('app', 'Reset Password'), ['class' => 'btn btn-primary', 'name' => 'reset-password-button']) ?>
</div>

<?php ActiveForm::end(); ?>