<?php

namespace app\controllers;
use app\components\AccessRule;
use app\models\Atendimento;
use app\models\Unidades;
use app\models\FormRelatorioProducaoUnidade;
use app\models\FormRelatorioProducaoUsuario;
use app\models\User;
use app\models\Users;
use kartik\mpdf\Pdf;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class RelatoriosController extends \yii\web\Controller
{
    public $layout = 'painel';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['create','update','updatepassword','randkey','delete'],
                'rules' => [
                    [
                        'actions'=>['create','update','updatepassword','randkey','delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProducaousuario(){
        $form = new FormRelatorioProducaoUsuario();

        if($form->load(\Yii::$app->request->post()) && $form->validate()){
            // get your HTML raw content without any layouts or scripts
            $form->data = str_replace(' - ','*',$form->data);
            $arr_dt = explode('*',$form->data);
            $data_ini = \Yii::$app->formatter->asDatetime($arr_dt[0],'php:Y-m-d H:i:s');
            $data_fim = \Yii::$app->formatter->asDatetime($arr_dt[1],'php:Y-m-d H:i:s');

            $producao = Atendimento::find();
            $dataProvider = new ActiveDataProvider([
                'query'=>$producao,
                'pagination'=>false,
            ]);
                if($form->user_id <> 0){
                    $producao->where(['usuario'=>$form->user_id]);
                    $usuario = Users::findOne($form->user_id);
                    $all = false;
                }else{
                    $usuario = Users::find()->all();
                    $all = true;
                }
            $producao->with(['usuario0']);
                $producao->andFilterWhere(['between','data',$data_ini,$data_fim])->all();


            if(\Yii::$app->request->post('tipo') == 'excel'){
                $file = \Yii::createObject([
                    'class' => 'codemix\excelexport\ExcelFile',
                    'sheets' => [
                        'Producao Usuario' => [
                            'class' => 'codemix\excelexport\ActiveExcelSheet',
                            'query' => $producao,
                            'attributes'=>[
                                'nome',
                                'solicitacao',
                                'tipo',
                                'data',
                                //['attribute'=>'data','format'=>['date','dd/MM/yyyy H:i:s']],
                                'usuario0.username'
                            ],
                            'formats' => [
                                // Either column name or 0-based column index can be used
                                3 => 'dd/mm/yyyy hh:mm:ss',
                            ],
                            'formatters' => [
                                // Dates and datetimes must be converted to Excel format
                                3 => function ($value, $row, $data) {
                                    return \PHPExcel_Shared_Date::PHPToExcel(strtotime($value));
                                },
                            ],
                        ]
                    ]
                ]);
                $date = date('dmYHis');
                $file->send('prod_usuario'.$date.'.xlsx');
            }else if(\Yii::$app->request->post('tipo') == 'pdf'){
                $content =  $this->renderPartial('_producaoUsuario',['dataProvider'=>$dataProvider,'arr_date'=>$arr_dt,'usuario'=>$usuario,'t'=>$all]);
                // setup kartik\mpdf\Pdf component
                $pdf = new Pdf([
                    // your html content input
                    'content' => $content,
                    // format content from your own css file if needed or use the
                    // enhanced bootstrap css built by Krajee for mPDF formatting
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                    // any css to be embedded if required
                    'cssInline' => '.kv-heading-1{font-size:18px}',
                    // set mPDF properties on the fly
                    'options' => ['title' => 'Produção por usuário'],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader'=>['Atendimento'],
                        'SetFooter'=>['{PAGENO}'],
                    ]
                ]);

                // return the pdf output as per the destination setting
                return $pdf->render();
            }
        }else{
            return $this->render('vw_producaoUsuario',['form'=>$form]);
        }
    }

    public function actionProducaounidade(){
        $form = new FormRelatorioProducaoUnidade();
        if($form->load(\Yii::$app->request->post()) && $form->validate()) {
            // get your HTML raw content without any layouts or scripts

            $form->data = str_replace(' - ','*',$form->data);
            $arr_dt = explode('*',$form->data);
            $data_ini = \Yii::$app->formatter->asDatetime($arr_dt[0],'php:Y-m-d H:i:s');
            $data_fim = \Yii::$app->formatter->asDatetime($arr_dt[1],'php:Y-m-d H:i:s');

            $producao = Atendimento::find();
            $dataProvider = new ActiveDataProvider([
                'query'=>$producao,
                'pagination'=>false,
            ]);
            $producao->where(['unidade_solicitante'=>$form->unidade_id])->orWhere(['unidade_encaminhada'=>$form->unidade_id]);
            if(count($form->unidade_id) == 1){
                $unidade = Unidades::findOne($form->unidade_id);
                $all = false;
            }else{
                $unidade = Unidades::find()->all();
                $all = true;
            }
            $producao->with(['usuario0','unidadeEncaminhada','unidadeSolicitante']);
            $producao->andFilterWhere(['between','data',$data_ini,$data_fim])->all();
            /*return print_r($producao);
            */
            if(\Yii::$app->request->post('tipo') == 'excel'){
                $file = \Yii::createObject([
                    'class' => 'codemix\excelexport\ExcelFile',
                    'sheets' => [
                        'Producao Unidade' => [
                            'class' => 'codemix\excelexport\ActiveExcelSheet',
                            'query' => $producao,
                            'attributes'=>[
                                'nome',
                                'solicitacao',
                                'tipo',
                                'unidadeEncaminhada.unidade',
                                'outro_encaminhada',
                                'unidadeSolicitante.unidade',
                                'outro_solicitante',
                                'data',
                                //['attribute'=>'data','format'=>['date','dd/MM/yyyy H:i:s']],
                                'usuario0.username'
                            ],
                            'titles' => [
                                'Nome',
                                'Solicitacao',
                                'Tipo',
                                'Unidade Encaminhada',
                                'Outro Encaminhada',
                                'Unidade Solicitante',
                                'Outro Solicitante',
                                'Data',
                                'Usuario'
                            ],
                            'formats' => [
                                // Either column name or 0-based column index can be used
                                7 => 'dd/mm/yyyy hh:mm:ss',
                            ],
                            'formatters' => [
                                // Dates and datetimes must be converted to Excel format
                                7 => function ($value, $row, $data) {
                                    return \PHPExcel_Shared_Date::PHPToExcel(strtotime($value));
                                },
                            ],
                        ]
                    ]
                ]);
                $date = date('dmYHis');
                $file->send('prod_unidade'.$date.'.xlsx');
            }else if(\Yii::$app->request->post('tipo') == 'pdf') {
                $content = $this->renderPartial('_producaoUnidade', ['dataProvider' => $dataProvider, 'arr_date' => $arr_dt, 'unidade' => $unidade, 't' => $all]);
                // setup kartik\mpdf\Pdf component
                $pdf = new Pdf([
                    // your html content input
                    'content' => $content,
                    // format content from your own css file if needed or use the
                    // enhanced bootstrap css built by Krajee for mPDF formatting
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                    // any css to be embedded if required
                    'cssInline' => '.kv-heading-1{font-size:18px}',
                    // set mPDF properties on the fly
                    'options' => ['title' => 'Produção por usuário'],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader' => ['Atendimento'],
                        'SetFooter' => ['{PAGENO}'],
                    ]
                ]);
                // return the pdf output as per the destination setting
                return $pdf->render();
            }
        }else{
            return $this->render('vw_producaoUnidade',['form'=>$form]);
        }
    }

}
