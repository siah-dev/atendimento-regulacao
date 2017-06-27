<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Unidades;
use kartik\select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Atendimento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atendimento-form">
    <?php $escape = new \yii\web\JsExpression("function(m) { return m; }"); ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome'); ?>

    <?= $form->field($model, 'solicitacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'unidade_solicitante')->widget(kartik\select2\Select2::classname(), [
        'data' => ArrayHelper::map(Unidades::find()->where(['tipo'=>'Solicitante'])->orderBy('unidade')->all(),'id','unidade'),
        'options' => ['placeholder' => 'Selecione a unidade solicitante ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'escapeMarkup' => $escape,
        ],
    ]);
    ?>

    <?= $form->field($model, 'unidade_encaminhada')->widget(kartik\select2\Select2::classname(), [
        'data' => ArrayHelper::map(Unidades::find()->where(['tipo'=>'Executante'])->orderBy('unidade')->all(),'id','unidade'),
        'options' => ['placeholder' => 'Selecione a unidade encaminhada ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'escapeMarkup' => $escape,
        ],
    ]);
    ?>


    <?= $form->field($model, 'tipo')->dropDownList(
        ['DISCADA'=>'DISCADA','RECEBIDA'=>'RECEBIDA'],
        [
            'prompt'=>'TIPO',
        ]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        ['ATENDIDA'=>'ATENDIDA','NÃO ATENDIDA'=>'NÃO ATENDIDA','PENDENTE'=>'PENDENTE'],
        [
            'prompt'=>'STATUS',
        ]) ?>

    <?php
    if($model->isNewRecord){
    echo $form->field($model, 'data')->hiddenInput(['value'=>Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s'),'php:Y-m-d H:i:s')])->label(false);
    }
    echo $form->field($model, 'data_ult_att')->hiddenInput(['value'=>Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s'),'php:Y-m-d H:i:s')])->label(false);
    ?>

    <?= $form->field($model, 'usuario')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
