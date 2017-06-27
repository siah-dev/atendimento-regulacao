<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= $msg ?></h3>

<h1>Registro</h1>
<?php $form = ActiveForm::begin([
    'method' => 'post',
	 'id' => 'formulario',
	 'enableClientValidation' => false,
	 'enableAjaxValidation' => false,
]);
?>
    <div class="form-group">
        <?= $form->field($model, "name")->input("text")->label('Nome') ?>
    </div>

<div class="form-group">
 <?= $form->field($model, "username")->input("text")->label('Usuário') ?>
</div>

<div class="form-group">
 <?= $form->field($model, "email")->input("email")->label('E-mail') ?>
</div>

<div class="form-group">
 <?= $form->field($model, "password")->input("password")->label('Senha') ?>
</div>

<div class="form-group">
 <?= $form->field($model, "password_repeat")->input("password")->label('Repetir Senha') ?>
</div>

    <div class="form-group">
        <?= $form->field($model, "role")->input("text")->label('Regra')->dropDownList([2=>'Usuário comum',1=>'Administrador']) ?>
    </div>

<?= Html::submitButton("Registrar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>