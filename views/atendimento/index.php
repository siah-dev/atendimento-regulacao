<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchAtendimento */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Atendimentos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atendimento-index">
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
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'NOVO ATENDIMENTO'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nome',
            'solicitacao:ntext',
            'unidadeSolicitante.unidade:text:Unidade Solicitante',
            'unidadeEncaminhada.unidade:text:Unidade Executante',
            'tipo',
            'status',
            [
                'attribute'=>'data',
                'filter'=> \kartik\daterange\DateRangePicker::widget([
                    'name'=>'SeachAtendimento[data]',
                    'attribute'=>'data_range',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'timePicker'=>true,
                        'timePickerIncrement'=>30,
                        'locale'=>[
                            'format'=>'d/m/Y H:i:s'
                        ]
                    ]
                ]),
                'format'=>['date','dd/MM/yyyy H:i:s']
            ],
            // 'usuario',
            ['class' => 'yii\grid\ActionColumn',
                'visibleButtons'=>['delete'=>\app\models\User::isUserAdmin(Yii::$app->user->identity->id)]
            ],

        ],
    ]); ?>

</div>
