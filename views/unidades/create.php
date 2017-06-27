<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Unidades */

$this->title = Yii::t('app', 'Nova unidade');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unidades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unidades-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
