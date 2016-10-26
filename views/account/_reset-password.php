<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<div class="row">
    <div class="col-md-6"><?= $form->field($model, 'password')->passwordInput() ?></div>
    <div class="col-md-6"><?= $form->field($model, 'password_repeat')->passwordInput() ?></div>
</div>

