<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UnidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Unidades');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?= Yii::$app->session->getFlash('success') ?></h4>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?= Yii::$app->session->getFlash('error') ?></h4>

        </div>
    <?php endif; ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
            <?= Html::a(Yii::t('app', 'NOVO'), ['create'], ['class' => 'btn btn-success']) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="panel-body">
            <p>
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'unidade',
                        'tipo',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
            </p>
        </div>
    </div>
</div>
