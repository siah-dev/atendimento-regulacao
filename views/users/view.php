<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuários'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Html::encode($this->title) ?></div>
        <div class="panel-body">
            <div class="col-md-6">

    <p>
        <?= Html::a(Yii::t('app', 'Atualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Excluir'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Deseja apagar o item selecionado?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'username',
            'email:email',
            [
                'attribute'=>'password',
                'value'=> '**********',
            ],
            //'authKey',
            //'accessToken',
            [
                'attribute'=>'activate',
                'value'=> $model->activate == 1?'Ativado':'Desativado',
            ],
            [
                'attribute'=>'role',
                'value'=> $model->role == 1?'Administrador':'Usuário Comum',
            ]
            //'lastChangePassword',
        ],
    ]) ?>
            </div>
        </div>
    </div><!-- /.col-->