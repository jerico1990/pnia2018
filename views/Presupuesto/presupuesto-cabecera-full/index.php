<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Presupuesto\PresupuestoCabeceraFullSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if ($title != null){
    $this->title = $title;
}else{
    $this->title = 'Presupuesto Cabeceras';
}
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<script type="text/javascript">

    function actualizarVariable(presupuesto_id,campo,item_id){

        var valor =  (document).getElementById(item_id).value;

        $.post("<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-full/actualizar-datos",
            {
                presupuesto_id  : presupuesto_id,
                campo           : campo,
                valor           : valor
            }, function(data,status) {
                if(data == 1 ){
                    ///alert('status: '+status+'  data: '+data);
                    $.pjax.reload({
                        container:'#crud-datatable-pjax',
                    });
                }else{
                    alert('El monto ingresado excede el presupuesto disponible.');
                }

            });
/*
        }.,
            success:function(text){
                //alert(text);
                //alert("hello Aegwyng");
                //console.log(text);
                $.pjax.reload({
                    container:'#crud-datatable-pjax',
                });
            },
            fail:function(text){
                alert('fail'+text);
            }
        });// */

/*
        $.ajax({
            url: "<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-full/actualizar-datos",
            method: 'POST',
            data: {
                presupuesto_id  : presupuesto_id,
                campo           : campo,
                valor           : valor
            },
            success:function(text){
                //alert(text);
                //alert("hello Aegwyng");
                //console.log(text);
                $.pjax.reload({
                    container:'#crud-datatable-pjax',
                });
            },
            fail:function(text){
                alert('fail'+text);
            }
        });// */

        /*
        $.post( "<?= Url::base() ?>/Presupuesto/presupuesto-cabecera-full/actualizar-datos", function() {
            alert( "success" );
        })
            .done(function() {
                alert( "second success" );
            })
            .fail(function() {
                alert( "error" );
            })
            .always(function() {
                alert( "finished" );
            }); // */
    }

</script>


<div class="presupuesto-cabecera-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => $columns,
            'rowOptions' => function ($data){
                if ($data['es_hoja']){
                    return [];
                }
                $nivel = $data['nivel'];

                switch ($nivel){
                    case 0:
                        return ['style'=>'color:'.'white'.'; background-color:'.'rgb(146,166,196)'.';'.'font-weight:bold;'];
                        break;
                    case 1:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(216,230,237)'.';'];
                        break;
                    case 2:
                        return ['style'=>'color:'.'black'.'; background-color:'.'rgb(230,244,251)'.';'];
                        break;
                    case 3:
                        return ['style'=>'color:'.'white'.'; background-color:'.'rgb(160,187,168)'.';'.'font-weight:bold;'];
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
                        return ['style'=>'color:'.'white'.'; background-color:'.'rgb(175,176,179)'.';'.'font-weight:bold;'];
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
            //require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Crear Nuevo Presupuesto Cabecera','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reiniciar Vista']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> 
                        '.$this->title,
                'before'=>'<em>'.Yii::$app->params['textoEspañol']['mensajeCabecera'].'</em>',
                /*'after'=>BulkButtonWidget::widget([
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
