<?php
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Relatórios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <?= \yii\helpers\Html::a('PRODUÇÃO USUÁRIO',['relatorios/producaousuario'],['class'=>'btn btn-primary']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= \yii\helpers\Html::a('PRODUÇÃO POR UNIDADE',['relatorios/producaounidade'],['class'=>'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
</div>