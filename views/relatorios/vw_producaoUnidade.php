<?php
use kartik\daterange\DateRangePicker;
use yii\bootstrap\ActiveForm;
use app\models\Users;
use yii\helpers\ArrayHelper;
use kartik\select2;
use app\models\Unidades;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = Yii::t('app', 'Produção Unidade');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatórios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-6">

        <?php $ac_form = ActiveForm::begin([
            'method' => 'post',
            'options'=>[
                'target'=>'_blank'
            ]
        ]); ?>
        <div class="form-group">
            <?=
            $ac_form->field($form, 'unidade_id')->widget(select2\Select2::classname(), [
                'data' => ArrayHelper::map(Unidades::find()->orderBy('unidade')->groupBy('unidade')->all(),'id','unidade'),
                'language' => 'pt-br',
                'options' => ['placeholder' => 'Selecione a unidade ...','multiple'=>true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>


        </div>
        <div class="form-group">
            <label>Intervalo:</label>
            <?= DateRangePicker::widget([
                'model'=>$form,
                'attribute'=>'data',
                'value'=>'0000-00-00 00:00:00 - 0000-00-00 23:59:59',
                'convertFormat'=>true,
                'pluginOptions'=>[
                    'timePicker'=>true,
                    'timePickerIncrement'=>59,
                    'presetDropdown'=>true,
                    'locale'=>[
                        'format'=>'d-m-Y H:i:s',
                    ],
                ]
            ]);
            ?>
        </div>
</div>
            <div class="form-group">
                Excel: <input type="radio" name="tipo" value="excel">
                PDF: <input type="radio" name="tipo" value="pdf" required checked>
            </div>
        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('Relatório',['class' => 'btn btn-primary','formtarget'=>'_blank']); ?>
        </div>

<?php ActiveForm::end(); ?>
        </div>
    </div>
</div><!-- /.col-->