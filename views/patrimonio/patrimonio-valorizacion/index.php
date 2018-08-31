<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use \yii2mod\alert\Alert;


$url_base = Url::base();
//Yii::$app->session->setFlash('success', "Your message to display");
?>


<div class="patrimonio-valorizacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model,'ultima_valorizacion')->textInput(['prompt'=>'Ninguna','readOnly'=> true])->label("Última valorización")?>

    <?php echo $form->field($model, 'fecha')->widget(DatePicker::classname(),
        [
            'name' => 'fecha',
            'removeButton' => false,
            
            'pluginOptions' => [
                'autoclose' => true,
                'startView'=>'year',
                'minViewMode'=>'months',
                'format' => 'yyyy-mm'
            ]
        ]);
    ?>
  
    <?php ActiveForm::end(); ?>
    
</div>
<input type="button" value="Valorizar" class="btn btn-success" name="valorizar" id="valorizar">

<?php 
echo \yii2mod\alert\Alert::widget([
    'useSessionFlash' => false,
    'options' => [
        'type' => 'info',
        'title' => '¡Atención!',
        'text' => "
        - No puede valorizar en función de un mes anterior al último valorizado
        - No puede valorizar con más de un mes de diferencia al mes actual
        ",
        'closeOnConfirm' => true,
        'animation' => "slide-from-top",
    ]
]);


$this->registerJS("
    $('#valorizar').click(function(){
        $.ajax({
             url: '$url_base/Patrimonio/patrimonio-valorizacion/valorizar',
                method: 'POST',
                data:{ 
                     fecha_valorizacion: $('#patrimoniovalorizacion-fecha').val()
                },
                success:function(text){
                    if(text.indexOf('valorizó') >= 0){
                        swal({
                            title: text,
                            tipe: 'warning'
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                location.reload();
                                return true;
                            } else {
                                $(select).val(prev_val); // use select reference to reset value
                               return false;
                            }
                        });
                    }
                    else{
                        swal(text,'','warning');
                    }
                },
                fail:function(text){
                    alert('fail'+text);
                }
        });

    });
");
?>

