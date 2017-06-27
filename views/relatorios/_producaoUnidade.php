<?php
use yii\grid\GridView;
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h4>ATENDIMENTO POR UNIDADE <?= $t?'':'('.$unidade->unidade.')'; ?>
                    <p class="small">Período: <?= $arr_date[0] ?> a <?= $arr_date[1] ?></p>
                    <hr />
                </h4>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'nome',
                'solicitacao',
                'tipo',
                'unidadeEncaminhada.unidade:text:Unid. Enc.',
                'unidadeSolicitante.unidade:text:Unid. Sol.',
                ['attribute'=>'data','format'=>['date','dd/MM/yyyy H:i:s']],
                'usuario0.username:ntext:Usuario'
                // ...
            ],
        ]) ?>
    </div>
