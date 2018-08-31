<?php

namespace app\models\Presupuesto;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Presupuesto\PresupuestoCabecera;

/**
 * PresupuestoCabeceraFinalSearch represents the model behind the search form about `app\models\Presupuesto\PresupuestoCabecera`.
 */
class PresupuestoCabeceraFinalSearch extends PresupuestoCabecera
{

    //public $numeracion_linea;
    //public $nombre_linea;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeracion_linea','nombre_linea'],'string'],
            [['presupuesto_cabecera_id', 'presupuesto_version_id', 'partida_id', 'presupuesto_cabecera_padre_id', 'presupuesto_cabecera_id_original', 'jerarquia', 'actualizado_por', 'creado_por'], 'integer'],
            [['actualizado_en', 'creado_en'], 'safe'],
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
    public function search($params, $solo_factibilidad  = false)
    {
        //PresupuestoCabecera::findOne()->lineaNivel->numeracion;

        $query = PresupuestoCabecera::find();
        //->where("linea_nivel.numeracion like '".$this->numeracion_linea."%'")
        //->where("linea_nivel.numeracion like '2%'")
        /*
        ->leftJoin(LineaNivel::tableName(),
            'presupuesto_cabecera.linea_nivel_id = linea_nivel.linea_nivel_id')
        ->orderBy('linea_nivel.numeracion'); // */

        //$query->where("linea_nivel.numeracion like '1%'");


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'presupuesto_cabecera_id' => $this->presupuesto_cabecera_id,
            'presupuesto_version_id' => $this->presupuesto_version_id,
            'partida_id'     => $this->partida_id,
            'presupuesto_cabecera_padre_id' => $this->presupuesto_cabecera_padre_id,
            'presupuesto_cabecera_id_original' => $this->presupuesto_cabecera_id_original,
            'jerarquia'      => $this->jerarquia,
            'actualizado_en' => $this->actualizado_en,
            'actualizado_por' => $this->actualizado_por,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
        ]);

        /*
                $query->andFilterWhere(['like', 'linea_nivel.nombre_linea', $this->nombre_linea]);

                if (isset($this->numeracion_linea) AND $this->numeracion_linea != null AND $this->numeracion_linea != ""){
                    $query->andFilterWhere(['like', 'linea_nivel.numeracion', $this->numeracion_linea.'%',false]);
                }// */


        if (isset($_SESSION['version_busqueda'])){
            $query->andFilterWhere(['presupuesto_version_id' => $_SESSION['version_busqueda']]);
        }

        if ( !$solo_factibilidad AND isset($_SESSION['anho_busqueda']) AND $_SESSION['anho_busqueda'] != null AND $_SESSION['anho_busqueda'] != '' ){
            $query->leftJoin(Presupuesto::tableName(),
                'presupuesto.presupuesto_cabecera_id =
                 presupuesto_cabecera.presupuesto_cabecera_id')
                ->leftJoin(Periodo::tableName(),
                    'periodo.periodo_id = presupuesto.periodo_id')
                ->andWhere ('(periodo.mes = 1 AND periodo.anho = '.$_SESSION['anho_busqueda'].')');
            ;
        }// */

        return $dataProvider;
    }
}
