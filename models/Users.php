<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property integer $activate
 * @property integer $role
 * @property integer $lastChangePassword
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'password'], 'required'],
            [['activate', 'role'], 'integer'],
            [['lastChangePassword'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['username'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 80],
            [['password', 'authKey', 'accessToken'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Nome'),
            'username' => Yii::t('app', 'Usuário'),
            'email' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Senha'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'activate' => Yii::t('app', 'Ativado'),
            'role' => Yii::t('app', 'Regra'),
            'lastChangePassword' => Yii::t('app', 'Ultima senha alterada'),
        ];
    }

    public function getAtendimentos()
    {
        return $this->hasMany(Atendimento::className(), ['usuario' => 'id']);
    }


}
