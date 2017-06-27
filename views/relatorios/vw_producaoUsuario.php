<?php
use kartik\daterange\DateRangePicker;
use yii\bootstrap\ActiveForm;
use app\models\Users;
use yii\helpers\ArrayHelper;
$this->title = Yii::t('app', 'Produção usuário');
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
            <?= $ac_form->field($form,'user_id')
                ->dropDownList(ArrayHelper::map(array_merge([0=>['id'=>0,'name'=>'TODOS']],Users::find()->all()),'id','name')); ?>
        </div>

        <div class="form-group">
            <?= '<label>Intervalo</label>' ?>
        <?= DateRangePicker::widget([
            'model'=>$form,
            'attribute'=>'data',
            'convertFormat'=>true,
            'pluginOptions'=>[
                'timePicker'=>true,
                'timePickerIncrement'=>59,
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
                PDF: <input type="radio" name="tipo" value="pdf" required checked >
            </div>
        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('Relatório',['class' => 'btn btn-primary','formtarget'=>'_blank']); ?>
        </div>

<?php ActiveForm::end(); ?>
        </div>
    </div>
</div><!-- /.col-->