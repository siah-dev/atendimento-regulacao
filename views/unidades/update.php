<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unidades */

$this->title = Yii::t('app', 'Atualizar {modelClass}: ', [
    'modelClass' => 'Unidades',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unidades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="unidades-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
