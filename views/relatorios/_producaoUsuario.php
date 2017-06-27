<?php
use yii\grid\GridView;
?>


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h4>ATENDIMENTO POR USUÁRIO (<?= $t?'TODOS':$usuario->name; ?>)
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
                ['attribute'=>'data','format'=>['date','dd/MM/yyyy H:i:s']],
                'usuario0.username:ntext:Usuario'
                // ...
            ],
        ]) ?>
    </div>
