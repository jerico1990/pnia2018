<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioMovimiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patrimonio-movimiento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patrimonio_item_id')->dropDownList($items,array('prompt'=>'Ninguno')) ?>
    
    <?= $form->field($model_item, 'descripcion')->textInput(['maxlength' => true,'disabled' => true])?>
    
    <?= $form->field($model_item, 'marca')->textInput(['maxlength' => true,'disabled' => true]) ?>

    <?= $form->field($model_item, 'modelo')->textInput(['maxlength' => true,'disabled' => true]) ?>

    <?= $form->field($model_item, 'serie')->textInput(['maxlength' => true,'disabled' => true]) ?>

    <!-- Tipo de movimiento -->
    <?= $form->field($model, 'metacodigo_id')->dropDownList($metacodigos) ?>

    <?= $form->field($model, 'ubicacion_inicial_id')->dropDownList($ubicaciones,array('prompt'=>'Ninguno')) ?>
    
    <?= $form->field($model, 'ubicacion_final_id')->dropDownList($ubicaciones,array('prompt'=>'Ninguno')) ?>
    
    <!-- <?= $form->field($model, 'persona_aut')->dropDownList($user,array('prompt'=>'Ninguno')) ?> -->
    <?= $form->field($model, 'autocomplete_staff_persona_aut')->widget(Typeahead::classname(), [
                'options' => ['placeholder' => 'Buscar ... '],
                'pluginOptions' => ['highlight'=>true],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('nombre_completo')",
                        'display' => 'nombre_completo',
                        'remote' => [
                            'url' => Url::base().'/rrhh/staff-persona/autocompletar-nombre-completo'. '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ]

                    ]
                ]
            ]);
        ?>

    <!-- <?= $form->field($model, 'persona_rec')->dropDownList($user,array('prompt'=>'Ninguno')) ?> -->
    <?= $form->field($model, 'autocomplete_staff_persona_rec')->widget(Typeahead::classname(), [
                'options' => ['placeholder' => 'Buscar ... '],
                'pluginOptions' => ['highlight'=>true],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('nombre_completo')",
                        'display' => 'nombre_completo',
                        'remote' => [
                            'url' => Url::base().'/rrhh/staff-persona/autocompletar-nombre-completo'. '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ]

                    ]
                ]
            ]);
        ?>



    <?php echo $form->field($model, 'fecha_salida')->widget(DatePicker::classname(),[
            'name' => 'fecha_salida_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?php echo $form->field($model, 'fecha_retorno')->widget(DatePicker::classname(),[
            'name' => 'fecha_retorno_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php
$this->registerJs("
    $('#patrimoniomovimiento-patrimonio_item_id').on('change',function(){
        if($(this).val()==''){
            $('#patrimonioitem-descripcion').val('');
            $('#patrimonioitem-marca').val('');
            $('#patrimonioitem-modelo').val('');
            $('#patrimonioitem-serie').val('');
        }
        else{
            $.ajax({
                url: '".yii\helpers\Url::toRoute("Patrimonio/patrimonio-movimiento/lista-items-patrimonio")."',
                dataType: 'json',
                method: 'GET',
                data: {id: $(this).val()},
                success: function (data, textStatus, jqXHR) {
                    $('#patrimonioitem-descripcion').val(data.descripcion);
                    $('#patrimonioitem-marca').val(data.marca);
                    $('#patrimonioitem-modelo').val(data.modelo);
                    $('#patrimonioitem-serie').val(data.serie);
                },
                beforeSend: function (xhr) {
                    //alert('loading!');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('An error occured!');
                    alert('Error in ajax request');
                }
            });
        }
    });"
); 

?>
