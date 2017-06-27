<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Atendimento */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Atendimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atendimento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Atualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= \app\models\User::isUserAdmin(Yii::$app->user->identity->id)? Html::a(Yii::t('app', 'Excluir'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Deseja realmente deletar este atendimento?'),
                'method' => 'post',
            ],
        ]):''; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nome:text',
            'solicitacao:ntext',
            'unidadeSolicitante.unidade:text:Unidade Solicitante',
            'unidadeEncaminhada.unidade:text:Unidade Encaminhada',
            'outro_solicitante:text:Outro (Solicitante)',
            'outro_encaminhada:text:Outro (Encaminhada)',
            'tipo',
            'status',
            ['attribute'=>'data','format'=>['date','php:d/m/Y H:i:s']],
            ['attribute'=>'data_ult_att','label'=>'Última atualização','format'=>['date','php:d/m/Y H:i:s']],
            'usuario0.name',
        ],
    ]) ?>

</div>
