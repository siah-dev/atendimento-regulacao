<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Atendimento */

$this->title = Yii::t('app', 'Atualizar {modelClass}: ', [
    'modelClass' => 'Atendimento',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Atendimentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Atualizar');
?>
<div class="atendimento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
