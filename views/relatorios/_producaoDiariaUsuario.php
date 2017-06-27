<?php
use yii\grid\GridView;
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h4>ATENDIMENTO DIARIO
                    <p class="small">Data: <?= $inicio ?> a <?= $fim ?></p>
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
                'outro_encaminhada:text:(Outro) Encaminhada',
                'unidadeSolicitante.unidade:text:Unid. Sol.',
                'outro_solicitante:text:(Outro) Solicitante',
                ['attribute'=>'data','format'=>['date','dd/MM/yyyy H:i:s']],
                'usuario0.username:ntext:Usuario'
                // ...
            ],
        ]) ?>
    </div>
