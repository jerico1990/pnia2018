<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mensaje;

/**
 * MensajeSearch represents the model behind the search form about `app\models\Mensaje`.
 */
class MensajeSearch extends Mensaje
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mensaje_id', 'usuario_id_de', 'usuario_id_para'], 'integer'],
            [['titulo', 'mensaje', 'status', 'creado_en'], 'safe'],
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
        $query = Mensaje::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!Yii::$app->user->isGuest) {
            $this->usuario_id_para = Yii::$app->user->identity->usuario_id;
        } else {
            $this->usuario_id_para = 0;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'mensaje_id' => $this->mensaje_id,
            'usuario_id_de' => $this->usuario_id_de,
            'usuario_id_para' => $this->usuario_id_para,
            'creado_en' => $this->creado_en,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'mensaje', $this->mensaje])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
