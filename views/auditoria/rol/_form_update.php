<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\helpers\Url;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Rol */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rol-update-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<div class="rol-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-rol-proceso',
            'dataProvider' => $proceso_dataProvider,
            'filterModel' => $proceso_searchModel,
            'pjax' => true,
            'columns' => [
                [
                    'header' => 'Procesos en el sistema',
                    'attribute' => 'descripcion'
                ],//////////////////////////////
                [
                    'header' => 'Ver',
                    'content' => function($model,$key,$index,$column){
                        if(isset($_SESSION['valoresSeleccionadosRol'][$model->proceso_id])){
                            return Html::checkbox(
                                'test',
                                in_array('view_'.$key,$_SESSION['valoresSeleccionadosRol'][$model->proceso_id])?true:false,
                                array(

                                    'id'=>'view_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'view_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                        }
                        else
                            return Html::checkbox(
                                'test',
                                false,
                                array(

                                    'id'=>'view_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'view_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                    },
                    'width' => '40px'
                ],
                [
                    'header' => 'Crear',
                    'content' => function($model,$key,$index,$column){
                        if(isset($_SESSION['valoresSeleccionadosRol'][$model->proceso_id])){
                            return Html::checkbox(
                                'test',
                                in_array('create_'.$key,$_SESSION['valoresSeleccionadosRol'][$model->proceso_id])?true:false,
                                array(

                                    'id'=>'create_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'create_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                        }
                        else
                            return Html::checkbox(
                                'test',
                                false,
                                array(

                                    'id'=>'create_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'create_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                    },
                    'width' => '40px'
                ],
                [
                    'header' => 'Actualizar',
                    'content' => function($model,$key,$index,$column){
                        if(isset($_SESSION['valoresSeleccionadosRol'][$model->proceso_id])){
                            return Html::checkbox(
                                'test',
                                in_array('update_'.$key,$_SESSION['valoresSeleccionadosRol'][$model->proceso_id])?true:false,
                                array(

                                    'id'=>'update_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'update_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                        }
                        else
                            return Html::checkbox(
                                'test',
                                false,
                                array(

                                    'id'=>'update_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'update_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                    },
                    'width' => '40px'
                ],
                [
                    'header' => 'Eliminar',
                    'content' => function($model,$key,$index,$column){
                        if(isset($_SESSION['valoresSeleccionadosRol'][$model->proceso_id])){
                            return Html::checkbox(
                                'test',
                                in_array('delete_'.$key,$_SESSION['valoresSeleccionadosRol'][$model->proceso_id])?true:false,
                                array(

                                    'id'=>'delete_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'delete_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                        }
                        else
                            return Html::checkbox(
                                'test',
                                false,
                                array(

                                    'id'=>'delete_'.$model->proceso_id,
                                    'onclick'=>'manejoSesion(id,"'.'delete_'.$model->proceso_id.'","'.$model->proceso_id.'")'

                                )
                            );
                    },
                    'width' => '40px'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true
        ]);
        ?>
        <script type="text/javascript">
            function manejoSesion(nuevo_seleccionado,check_id,proceso_id){
                var flag = (document).getElementById(check_id).checked;
                //alert(nuevo_seleccionado);
                // if(flag)
                //     $("[data-key="+tr_id+"]").addClass( "danger" );
                // else
                //     $("[data-key="+tr_id+"]").removeClass( "danger" );
                $.ajax({
                    url: "<?= Url::base() ?>/Auditoria/rol/modificar-sesion-rol",
                    method: 'POST',
                    data: {
                        nuevoSeleccionado : nuevo_seleccionado,
                        accion : flag,
                        proceso_id: proceso_id
                    },
                    success:function(text){
                        // alert(text);
                        console.log(text);
                    },
                    fail:function(text){
                        alert('fail'+text);
                    }
                });
            }

            $('#ajaxCrudModal').on('hidden.bs.modal', function () {
                window.location.replace("<?php echo Url::base().'/Auditoria/rol'?>");

            })

        </script>
               
        
    </div>
</div> 