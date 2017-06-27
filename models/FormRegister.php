<?php

namespace app\models;
use Yii;
use yii\base\model;
use app\models\Users;

class FormRegister extends model{

    public $name;
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $role;
    
    public function rules()
    {
        return [
            [['username', 'name','email', 'password', 'password_repeat','role'], 'required', 'message' => 'Campo requerido'],
            [['username','name'], 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'Minimo 3 e no máximo 50 caracteres.'],
            ['username', 'match', 'pattern' => "/^[0-9a-z.-]+$/i", 'message' => 'Só é aceito letras e números.'],
            ['username', 'username_existe'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Minimo 5 e no máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato inválido'],
            ['email', 'email_existe'],
            ['password', 'match', 'pattern' => "/^.{6,16}$/", 'message' => 'Minimo 6 e no máximo 16 caracteres.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'As senhas não coincidem.'],
        ];
    }
    
    public function email_existe($attribute, $params)
    {
  
  //Buscar el email en la tabla
  $table = Users::find()->where("email=:email", [":email" => $this->email]);
  
  //Si el email existe mostrar el error
  if ($table->count() == 1)
  {
                $this->addError($attribute, "O email selecionado já existe.");
  }
    }
 
    public function username_existe($attribute, $params)
    {
  //Buscar el username en la tabla
  $table = Users::find()->where("username=:username", [":username" => $this->username]);
  
  //Si el username existe mostrar el error
  if ($table->count() == 1)
  {
                $this->addError($attribute, "O usuário selecionado já existe.");
  }
    }
 
}