<?php

namespace app\controllers;

use app\models\Atendimento;
use app\models\Unidades;
use app\models\User;
use app\models\Users;
use yii\base\Exception;

class ImportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionData(){
        $f = file(\Yii::$app->basePath.'/web/dados/todosword2excel.csv');
        $msg = '';
        $total = 0;
        foreach($f as $k => $v){
            list($nome,$solicitacao,$tipo,$unidadeenc,$outroencaminhada,$unidadesol,$outrosolicitante,$data,$usuario) = explode(';',$v);
            $unid_s = Unidades::find()->andWhere(['unidade'=>utf8_encode(trim($unidadesol))])->one();
            if(count($unid_s) == 0){
                $unid_s = $this->createUnidade(utf8_encode(trim($unidadesol)),'Solicitante');
            }
            $unid_e = Unidades::find()->andWhere(['unidade'=>utf8_encode(trim($unidadeenc))])->one();
            if(count($unid_e) == 0){
                $unid_e = $this->createUnidade(utf8_encode(trim($unidadeenc)),'Executante');
            }
            $u = Users::find()->andWhere(['username'=>trim($usuario)])->one();
            if(count($u) == 0){
                $u = $this->createUser(trim($usuario));
            }
            $atendimento = new Atendimento();
            $atendimento->usuario = $u->id;
            $atendimento->nome = utf8_encode($nome);
            $atendimento->solicitacao = utf8_encode($solicitacao);
            $atendimento->tipo = utf8_encode($tipo);
            $atendimento->status = 'SEM INFORMACAO';
            $atendimento->unidade_encaminhada = $unid_e->id;
            $atendimento->unidade_solicitante = $unid_s->id;
            $atendimento->outro_solicitante = utf8_encode($outrosolicitante);
            $atendimento->outro_encaminhada = utf8_encode($outroencaminhada);
            $atendimento->data = $this->cDate($data);
            try{
                $atendimento->save();
                $msg = 'Inserido com sucesso';
            }catch (\PDOException $e){
                $msg = 'Erro';
            }
            $total++;
        }
        return $this->render('index',['msg'=>$msg,'total'=>$total]);
    }

    private function cDate($date){
        $d = explode('_',$date);
        $arrdate = explode('/',$d[0]);
        return $arrdate[2].'-'.$arrdate[1].'-'.$arrdate[0].' '.$d[1];
    }

    private function createUser($usuario){
        $createUser = new Users();
        $createUser->name = $usuario;
        $createUser->username = $usuario;
        $createUser->password = '1fTokpg5cLx/E';
        $createUser->email = 'example@example.com';
        $createUser->activate = 1;
        $createUser->role = 2;
        $createUser->lastChangePassword = null;
        if(!$createUser->save()){
            throw new \Exception('Falha ao salvar usuário',500);
        }
        return $createUser;
    }
    private function createUnidade($unidade,$tipo){
        $createUnidade = new Unidades();
        $createUnidade->unidade = $unidade;
        $createUnidade->tipo = $tipo;
        if(!$createUnidade->save()){
            throw new \Exception('Falha ao salvar unidade',500);
        }
        return $createUnidade;
    }
}
