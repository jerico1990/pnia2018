<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Presupuesto\Periodo;
use app\models\Presupuesto\PresupuestoVersion;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Presupuesto\PresupuestoCabeceraFinalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if ($es_factibilidad){
    $this->title = 'Factibilidad';
}else{
    $this->title = 'Edición POA';
}

$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);

?>

<script type="text/javascript">
    function actualizarVariable(presupuesto_id,campo,item_id) {
        var valor = (document).getElementById(item_id).value;
        $.post("<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-final/actualizar-datos",
            {
                presupuesto_id: presupuesto_id,
                campo: campo,
                valor: valor
            }, function (data, status) {
                if (data == 1) { $.pjax.reload({container: '#crud-datatable-pjax',});
                } else { alert('El monto ingresado excede el presupuesto disponible.'); }
            }
        );
    }

    function setFiltroAnho() {
        var valor = (document).getElementById('anho_presupuesto_cb').value;
        $.post("<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-final/guardar-session",
            {
                nombre_session: 'anho_busqueda',
                valor: valor
            }, function (data, status) {
                if (data == 1) { $.pjax.reload({container: '#crud-datatable-pjax',});
                } else { alert('Error en el envio de datos.'); }
            }
        );
    }

    function setFiltroVersion() {
        var valor = (document).getElementById('version_presupuesto_cb').value;
        $.post("<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-final/guardar-session",
            {
                nombre_session: 'version_busqueda',
                valor: valor
            }, function (data, status) {
                if (data == 1) { $.pjax.reload({container: '#crud-datatable-pjax',});
                } else { alert('Error en el envio de datos.'); }
            }
        );
    }


</script>

<?php
    if (!$es_factibilidad){
        if (isset($_SESSION['anho_busqueda'])){
            $anho_seleccionado = [$_SESSION['anho_busqueda']];
        }else{
            $anho_seleccionado = [];
        }
        if (isset($_SESSION['version_busqueda'])){
            $version_seleccionada = [$_SESSION['version_busqueda']];
        }else{
            $version_seleccionada = [];
        }

        $combo_box_anhos = Html::dropDownList('anho',
            $anho_seleccionado,
            Periodo::getComboBoxItemsAnhos(),
            [   'prompt'=>'Ninguno',
                'id'=>'anho_presupuesto_cb',
                'onchange' => 'setFiltroAnho()'
            ]/// opciones del widget
        );
        $combo_box_version = Html::dropDownList('version',
            $version_seleccionada,
            PresupuestoVersion::getComboBoxItems(),
            [   'prompt'=>'Ninguno',
                'id'=>'version_presupuesto_cb',
                'onChange' => 'setFiltroVersion()'
            ]/// opciones del widget
        );
        $opciones_filtrado = '<em>Año: </em>'.$combo_box_anhos.'  <em>Versión: </em>'.$combo_box_version;
    }else{
        if (isset($_SESSION['version_busqueda'])){
            $version_seleccionada = [$_SESSION['version_busqueda']];
        }else{
            $version_seleccionada = [];
        }

        $combo_box_version = Html::dropDownList('version',
            $version_seleccionada,
            PresupuestoVersion::getComboBoxItems(),
            [   'prompt'=>'Ninguno',
                'id'=>'version_presupuesto_cb',
                'onChange' => 'setFiltroVersion()'
            ]/// opciones del widget
        );
        $opciones_filtrado = '<em>Versión: </em>'.$combo_box_version;
    }

    $version_actual = ' No existe ningna versión actualmente.';
    $mi_ultima_version  = PresupuestoVersion::getUltimaVersion();
    if ($mi_ultima_version != null) {
        $version_actual = ' (Versión Activa: ' . $mi_ultima_version->nro_version . ')';
    }

?>

<?php if($es_factibilidad){ ?>
    <button class="pestanha-on" onclick="window.location.href='<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-final/index'">Vista Factibilidad</button>
    <button class="pestanha-off" onclick="window.location.href='<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-final/index-periodos'">Vista POA</button>
<?php
    $opciones_botonera =
        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
            ['role'=>'modal-remote','title'=> 'Crear Nueva Linea Factibilidad','class'=>'btn btn-default']);

}else{
    $opciones_botonera =
        Html::a('<i class="glyphicon glyphicon-calendar"></i>', ['create-poa'],
            ['role'=>'modal-remote','title'=> 'Crear Nueva Linea Factibilidad','class'=>'btn btn-default']).
        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create-nuevos-periodos'],
            ['role'=>'modal-remote','title'=> 'Create new Presupuesto Cabeceras','class'=>'btn btn-default']);
    ?>
    <button class="pestanha-off" onclick="window.location.href='<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-final/index'">Vista Factibilidad</button>
    <button class="pestanha-on" onclick="window.location.href='<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-final/index-periodos'">Vista POA</button>
<?php } ?>
<div class="presupuesto-cabecera-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => $columns,
            'rowOptions' => function ($model){
                if ($model['jerarquia'] == 2){
                    return [];
                }
                $nivel = $model->nivel;

                switch ($nivel){
                    case 0:
                        return ['style'=>'color:'.'white'.'; background-color:'.'rgb(146,166,196)'.';'];
                        break;
                    case 1:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(216,230,237)'.';'];
                        break;
                    case 2:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(230,244,251)'.';'];
                        break;
                    case 3:
                        return ['style'=>'color:'.'white'.'; background-color:'.'rgb(160,187,168)'.';'];
                        break;
                    case 4:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(232,244,232)'.';'];
                        break;
                    case 5:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(247,214,248)'.';'];
                        break;
                    case 6:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(250,241,218)'.';'];
                        break;
                    case 7:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(242,227,224)'.';'];
                        break;
                    case 8:
                        return ['style'=>'color:'.'white'.'; background-color:'.'rgb(175,176,179)'.';'];
                        break;
                    case 9:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(213,214,229)'.';'];
                        break;
                    default:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(224,226,225)'.';'];
                        break;

                }

                if ( $nivel  == 0){

                }else{
                    return ['style'=>'color:'.'black'.'; background-color:'.'rgb(242,227,224)'.';'];
                }

            },
            'toolbar'=> [
                ['content'=> $opciones_botonera.
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> '.$this->title,
                'before'=> $opciones_filtrado.$version_actual,
                /*
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',// */
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
