<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use humanized\localehelpers\Language as LanguageHelper;
use kartik\select2\Select2;
?>
<?php $form = ActiveForm::begin(['id' => 'form-settings']); ?>


<div class="form-group">
    <?= $form->field($model, 'name') ?>
    <?php
    $fnLabel = function($locale) {
        return LanguageHelper::native_label($locale) .' ('. LanguageHelper::label($locale, Yii::$app->language) .')';
    };
    ?>
    <?=
    $form->field($model, 'languages')->widget(Select2::classname(), [
        'data' => LanguageHelper::primary($fnLabel),
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]);
    ?>
    <?= Html::submitButton('Update Changes', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
</div>

<?php ActiveForm::end(); ?>