<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidades".
 *
 * @property integer $id
 * @property string $unidade
 * @property string $tipo
 *
 * @property Atendimento[] $atendimentos
 * @property Atendimento[] $atendimentos0
 */
class Unidades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unidades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unidade', 'tipo'], 'required'],
            [['unidade'], 'string', 'max' => 100],
            [['tipo'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'unidade' => Yii::t('app', 'Unidade'),
            'tipo' => Yii::t('app', 'Tipo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtendimentos()
    {
        return $this->hasMany(Atendimento::className(), ['unidade_encaminhada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtendimentos0()
    {
        return $this->hasMany(Atendimento::className(), ['unidade_solicitante' => 'id']);
    }
}
