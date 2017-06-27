<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FormRelatorioProducaoUnidade extends Model
{

    public $unidade_id;
    public $data;

    public function rules()
    {
        return [
            [['unidade_id','data'], 'required','message' => 'Campo requerido'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unidade_id' => 'Unidade',
            'data'=>'Data',
        ];
    }
}
