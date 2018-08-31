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
$url_base = Url::base();
$model->password_hash = "@@";
?>

<div class="rol-update-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    
<!--
    <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?> -->

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<div class="rol-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-rol-usuario',
            'dataProvider' => $rol_dataProvider,
            'filterModel' => $rol_searchModel,
            'pjax' => true,
            'columns' => [
                [
                    'header' => 'CheckBox',
                    'content' => function($model,$key,$index,$column){
                        return Html::checkbox(
                            'test',
                            in_array($key, $_SESSION['valoresSeleccionados'])?true:false,
                            array(

                                'id'=>'checkBoxRol_'.$model->rol_id,
                                'onclick'=>'manejoSesion("'.$key.'","'.'checkBoxRol_'.$model->rol_id.'","'.$model->rol_id.'")'

                            )
                        );
                    },
                    'width' => '20px'
                ],
                [
                    'header' => 'Roles en el sistema',
                    'attribute' => 'nombre'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true
        ]);
        ?>
        <script type="text/javascript">
            function manejoSesion(nuevoSeleccionado,check_id,tr_id){
                var flag = (document).getElementById(check_id).checked;
                // if(flag)
                //     $("[data-key="+tr_id+"]").addClass( "danger" );
                // else
                //     $("[data-key="+tr_id+"]").removeClass( "danger" );
                $.ajax({
                    url: "<?= Url::base() ?>/Auditoria/usuario/modificar-sesion",
                    method: 'POST',
                    data: {
                        nuevoSeleccionado : nuevoSeleccionado,
                        accion : flag
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
                window.location.replace("<?php echo Url::base().'/Auditoria/usuario'?>");

            })

        </script>
               
        
    </div>
</div>
<?php
$this->registerJs("

var nuevoSeleccionado;
// $('tr').change(function(obj){
//     if($(obj.currentTarget).attr('data-key')){
//         console.log($(obj.currentTarget).attr('data-key'));
//         nuevoSeleccionado=$(obj.currentTarget).attr('data-key');  
                            
//         $.ajax({
//             url: '".yii\helpers\Url::toRoute('Auditoria/usuario/modificar-sesion')."',
//             method: 'POST',
//             data: {
//                 nuevoSeleccionado:nuevoSeleccionado
//             },
//             success:function(text){
//                 // alert(text);
//                 console.log(text);
//             },
//             fail:function(text){
//                 alert(text);
//             }
//         });
//     }         
// });

// $('[name=\'RolSearch[nombre]\']').change(function(obj){
//     console.log(nuevoSeleccionado);
// });



$( document ).ready(function() {
    sessionStorage.clear();   
});



// $( '#crud-rol-usuario-container' ).click(function(obj) {
//     alert('click');
// });

// $('#crud-rol-usuario-container > table > tbody tr').change(function(obj){
//     console.log($(obj.currentTarget).attr('data-key'));
//     var nuevoSeleccionado=$(obj.currentTarget).attr('data-key');  
                
//     $.ajax({
//         url: 'usuario/modificar-sesion',
//         method: 'POST',
//         data: {
//             nuevoSeleccionado:nuevoSeleccionado
//         },
//         success:function(text){
//             alert(text);
//         },
//         fail:function(text){
//             alert(text);
//         }
//     });
// });

// $('#crud-rol-usuario-container > table > tbody tr').change(function(obj){
//     console.log($(obj.currentTarget).attr('data-key'));
//     var nuevoSeleccionado=$(obj.currentTarget).attr('data-key');  
                
//     $.ajax({
//         url: 'modificar-sesion',
//         method: 'POST',
//         data: {
//             nuevoSeleccionado:nuevoSeleccionado
//         },
//         success:function(text){
//             alert(text);
//         },
//         fail:function(text){
//             alert(text);
//         }
//     });

//     // alert(typeof vector);
//     // for(i=0;i<vector.length;i++){
//     //     alert(vector[i]);
//     // }

//     // if(vector[0])
//     //     vector = vector + ','' + nuevoSeleccionado;
//     // else
//     //     vector += nuevoSeleccionado;

//     // var array = JSON.parse('['' + string + '']'');
//     // vector+=nuevoSeleccionado;
//     // vector.forEach( function(valor, indice, array) {
//     //     console.log('En el índice '' + indice + '' hay este valor: '' + valor);
//     // }); 
//     // vector.forEach(function(value){
//     //     alert(value); 
//     // });

//     // foreach(vector as session){
//     //     if(session==nuevoSeleccionado) alert('sesion');
//     //         //unset(vector[i]);
//     //         vector+= nuevoSeleccionado;
//     //     }
                    
//     // alert(sessionStorage['valoresSeleccionados']);
//     // sessionStorage.valoresSeleccionados=vector;

//     // sessionStorage.setItem('valoresSeleccionados',seleccionados);
//     // localStorage.setItem('valoresSeleccionados',seleccionados);
// });

$('#modificar-roles').on('click', function() {
    //sessionStorage['valoresSeleccionados']=[];
    // var valoresSeleccionados = localStorage['valoresSeleccionados'];
    var roles=[0];
    $('#crud-rol-usuario-container > table > tbody tr').each(function() {
        if($(this).hasClass('danger')){
            var nuevoRol = $(this).attr('data-key');
            roles.push(nuevoRol);
        }
        
        //alert(rol);
    });
    //alert(roles);
    
    $.ajax({
        url: 'usuario/asignar-rol',
        method: 'POST',
        data:{  
            'usuario_id' : $model->usuario_id,
            'roles' : roles
        },
        beforeSend:function(){
            //alert('antes');
        },
        success:function(text){
            alert(text);
        },
        fail:function(text){
            alert(text);
        }
    });




    //$('#inputPrueba').append(roles[0]);
    //var rows = $(tbl).children('tbody').children('tr');
    //console.log(rows);
    //alert($model->usuario_id);
    //alert(rows);
    //$('#crud-rol-usuario-pjax tr')
    // var T = document.getElementById('crud-rol-usuario');
    // alert(T);
    // $(T).find('> #crud-rol-usuario-container > table > tbody > tr').each(function () {
    //     alert('prueba');
    // });
    
});"
); 