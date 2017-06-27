<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Unidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unidade')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tipo')->dropDownList(['Solicitante'=>'Solicitante','Executante'=>'Executante']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Adicionar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div><!-- /.col-->


