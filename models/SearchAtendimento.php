<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Atendimento;

/**
 * SearchAtendimento represents the model behind the search form about `app\models\Atendimento`.
 */
class SearchAtendimento extends Atendimento
{
    /**
     * @inheritdoc
     */
    public $data_start;
    public $data_end;
    public $data_range;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['unidadeEncaminhada.unidade','unidadeSolicitante.unidade']);
    }
    public function rules()
    {
        return [
            [['id', 'unidade_solicitante', 'unidade_encaminhada', 'usuario'], 'integer'],
            [['solicitacao', 'tipo', 'status', 'data','data_ult_att','unidadeSolicitante.unidade','unidadeEncaminhada.unidade','nome'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Atendimento::find();
        $query->with(['unidadeEncaminhada','unidadeSolicitante','usuario0']);
        if(!User::isUserAdmin(Yii::$app->user->id)){
            $query->andWhere(['usuario'=>Yii::$app->user->id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['unidadeSolicitante.unidade'] = [
            'asc' => ['unidadeSolicitante.unidade' => SORT_ASC],
            'desc' => ['unidadeSolicitante.unidade' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['unidadeEncaminhada.unidade'] = [
            'asc' => ['unidadeEncaminhada.unidade' => SORT_ASC],
            'desc' => ['unidadeEncaminhada.unidade' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'unidadeSolicitante.unidade' => $this->unidade_solicitante,
            'unidadeEncaminhada.unidade' => $this->unidade_encaminhada,
            'usuario' => $this->usuario,
        ]);

        $query->andFilterWhere(['like', 'solicitacao', $this->solicitacao])
            ->andFilterWhere(['like', 'tipo', $this->tipo])
            ->andFilterWhere(['like', 'status', $this->status]);

        $query->andFilterWhere(['between', 'data', $this->data, $this->data]);

        return $dataProvider;
    }
}
