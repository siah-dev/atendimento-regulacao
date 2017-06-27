<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UpdatePasswordForm extends Model
{

    public $oldpassword;
    public $newpassword;
    public $newpasswordrepeat;

    public function rules()
    {
        return [
            [['oldpassword', 'newpassword', 'newpasswordrepeat'], 'required','message' => 'Campo requerido'],
            [['oldpassword', 'newpassword', 'newpasswordrepeat'], 'string', 'max' => 250,'message' => 'Senha tem que ser menor que 250 caracteres'],
            ['newpasswordrepeat', 'compare', 'compareAttribute' => 'newpassword','message' => 'As senhas não coincidem'],
            ['oldpassword','findPasswords'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oldpassword' => 'Senha antiga',
            'newpassword' => 'Nova senha',
            'newpasswordrepeat' => 'Repetir nova senha'
        ];
    }
    public function findPasswords($attribute, $params){
        $user = Users::find()->where([
            'id'=>Yii::$app->user->identity->id
        ])->one();
        $password = $user->password;
        if($password!=crypt($this->oldpassword,Yii::$app->params['salt']))
            $this->addError($attribute,'Senha antiga inválida');
    }
}
