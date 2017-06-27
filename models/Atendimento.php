<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atendimento".
 *
 * @property integer $id
 * @property string $nome
 * @property string $solicitacao
 * @property integer $unidade_solicitante
 * @property integer $unidade_encaminhada
 * @property string $tipo
 * @property string $status
 * @property string $data
 * @property integer $usuario
 *
 * @property Unidades $unidadeEncaminhada
 * @property Unidades $unidadeSolicitante
 * @property Users $usuario0
 */
class Atendimento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'atendimento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'solicitacao', 'unidade_solicitante', 'unidade_encaminhada', 'tipo', 'status', 'data', 'usuario'], 'required'],
            [['solicitacao','outro_solicitante','outro_encaminhada'], 'string'],
            [['unidade_solicitante', 'unidade_encaminhada', 'usuario'], 'integer'],
            [['data','data_ult_att'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['tipo', 'status'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'solicitacao' => Yii::t('app', 'Solicitacao'),
            'unidade_solicitante' => Yii::t('app', 'Unidade Solicitante'),
            'unidade_encaminhada' => Yii::t('app', 'Unidade Encaminhada'),
            'tipo' => Yii::t('app', 'Tipo'),
            'status' => Yii::t('app', 'Status'),
            'data' => Yii::t('app', 'Data'),
            'usuario' => Yii::t('app', 'Usuario'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadeEncaminhada()
    {
        return $this->hasOne(Unidades::className(), ['id' => 'unidade_encaminhada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadeSolicitante()
    {
        return $this->hasOne(Unidades::className(), ['id' => 'unidade_solicitante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Users::className(), ['id' => 'usuario']);
    }
}
