<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{

    public $id_user;
    public $newpassword;
    public $newpasswordrepeat;

    public function rules()
    {
        return [
            [[ 'newpassword', 'newpasswordrepeat','id_user'], 'required','message' => 'Campo requerido'],
            [[ 'newpassword', 'newpasswordrepeat'], 'string', 'max' => 20,'message' => 'Senha tem que ser menor que 20 caracteres'],
            ['newpasswordrepeat', 'compare', 'compareAttribute' => 'newpassword','message' => 'As senhas não coincidem'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'newpassword' => 'Nova senha',
            'newpasswordrepeat' => 'Repetir nova senha'
        ];
    }

}
