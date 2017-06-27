<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = Yii::t('app', 'Atualizar {modelClass}: ', [
    'modelClass' => 'Usuário',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuários'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Atualizar');
?>
<div class="users-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelPassword'=>$modelPassword
    ]) ?>

</div>
