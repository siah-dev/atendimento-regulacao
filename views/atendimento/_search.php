<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchAtendimento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atendimento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'solicitacao') ?>

    <?= $form->field($model, 'unidade_solicitante') ?>

    <?= $form->field($model, 'unidade_encaminhada') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'usuario') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Pesquisar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Resetar'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
