<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FormRelatorioProducaoUsuario extends Model
{

    public $user_id;
    public $data;

    public function rules()
    {
        return [
            [['user_id','data'], 'required','message' => 'Campo requerido'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Usuário',
            'data'=>'Data',
        ];
    }
}
