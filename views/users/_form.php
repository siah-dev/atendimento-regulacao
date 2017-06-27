<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'activate')->dropDownList([1=>'Ativado',2=>'Desativado']) ?>

            <?= $form->field($model, 'role')->dropDownList([1=>'Administrador',2=>'Normal']) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Criar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>


    <?php if(!$model->isNewRecord): ?>
        <div class="col-md-4">
            <h4>Reiniciar <small>Senha</small></h4>
            <?php $formPassword = ActiveForm::begin(['action'=>Yii::$app->homeUrl.'users/resetpassword']); ?>
            <?= $formPassword->field($modelPassword, 'id_user')->hiddenInput(['value'=>$model->id])->label(false) ?>
            <?= $formPassword->field($modelPassword, 'newpassword')->passwordInput() ?>
            <?= $formPassword->field($modelPassword, 'newpasswordrepeat')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Alterar senha', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
        </div>
    </div>
</div><!-- /.col-->

