<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UpdatePasswordForm */
/* @var $form ActiveForm */
$this->title = 'Alterar senha';
?>
<div class="user-updatepassword">
    <h3>ALTERAR <small>SENHA</small></h3>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'oldpassword')->passwordInput() ?>
        <?= $form->field($model, 'newpassword')->passwordInput() ?>
        <?= $form->field($model, 'newpasswordrepeat')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- user-updatepassword -->