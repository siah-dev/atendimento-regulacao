<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Atendimento */

$this->title = Yii::t('app', 'Novo usuário');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuário'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-6">
<h3><?= $msg ?></h3>
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

</div>
</div>
</div><!-- /.col-->