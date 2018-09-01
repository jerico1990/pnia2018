<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\RequerimientoDetalle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requerimiento-detalle-form">

    <?php $form = ActiveForm::begin(['id'=>'detalle']); ?>
    <!--has-error  Asunto no puede estar vacío.-->

    <?php //= $form->field($model, 'linea_nivel_id')->textInput() ?>

    <!--has-error  Asunto no puede estar vacío.-->

    <div class="col-md-12">
      <?= $form->field($model, 'linea_nivel_id')->dropDownList($array_lineas_presupuesto, ['prompt'=>'Seleccionar','class'=>'linea-presupuestal form-control'])->label('Línea presupuesto') ?>
    </div>
    <!--
    <div class="form-group field-requerimientodetalle-linea_nivel_id col-md-12">
      <label class="control-label" for="requerimientodetalle-linea_nivel_id">Linea presupuesto</label>
      <select id="requerimientodetalle-linea_nivel_id" class="form-control" name="RequerimientoDetalle[linea_nivel_id]">
      </select>
      <div class="help-block" style="display:none">Linea de presupuesto no debe estar vacio</div>
    </div>
    -->
    <?php //= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-requerimientodetalle-descripcion col-md-12">
      <label class="control-label" for="requerimientodetalle-descripcion">Descripción</label>
      <textarea type="text" id="requerimientodetalle-descripcion" class="form-control" name="RequerimientoDetalle[descripcion]" maxlength="250" ></textarea>
      <div class="help-block"></div>
    </div>

    <?php //= $form->field($model, 'concepto')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-requerimientodetalle-concepto col-md-12">
      <label class="control-label" for="requerimientodetalle-concepto">Concepto</label>
      <input type="text" id="requerimientodetalle-concepto" class="form-control" name="RequerimientoDetalle[concepto]" maxlength="250">
      <div class="help-block"></div>
    </div>
    <div class="clearfix"></div>
    <?php //= $form->field($model, 'unidad_medida')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-requerimientodetalle-unidad_medida col-md-4">
      <label class="control-label" for="requerimientodetalle-unidad_medida">Unidad de Medida</label>
      <input type="text" id="requerimientodetalle-unidad_medida" class="form-control" name="RequerimientoDetalle[unidad_medida]" maxlength="50">
      <div class="help-block"></div>
    </div>
    <div class="clearfix"></div>
    <?php //= $form->field($model, 'cantidad')->textInput() ?>

    <div class="form-group field-requerimientodetalle-cantidad col-md-4">
      <label class="control-label" for="requerimientodetalle-cantidad">Cantidad</label>
      <input type="text" id="requerimientodetalle-cantidad" class="form-control" name="RequerimientoDetalle[cantidad]">
      <div class="help-block"></div>
    </div>

    <?php //= $form->field($model, 'costo_unitario')->textInput() ?>

    <div class="form-group field-requerimientodetalle-costo_unitario col-md-4">
      <label class="control-label" for="requerimientodetalle-costo_unitario">Costo Unitario</label>
      <input type="text" id="requerimientodetalle-costo_unitario" class="form-control" name="RequerimientoDetalle[costo_unitario]">
      <div class="help-block"></div>
    </div>

    <?php //= $form->field($model, 'monto_total')->textInput() ?>

    <div class="form-group field-requerimientodetalle-monto_total col-md-4">
      <label class="control-label" for="requerimientodetalle-monto_total">Monto Total</label>
      <input type="text" id="requerimientodetalle-monto_total" class="form-control" name="RequerimientoDetalle[monto_total]">
      <div class="help-block"></div>
    </div>
    <div class="clearfix"></div>
    <?php //= $form->field($model, 'rooc')->textInput() ?>

    <div class="form-group field-requerimientodetalle-rooc col-md-6">
      <label class="control-label" for="requerimientodetalle-rooc">Rooc</label>
      <input type="text" id="requerimientodetalle-rooc" class="form-control" name="RequerimientoDetalle[rooc]">
      <div class="help-block"></div>
    </div>

    <?php //= $form->field($model, 'ro')->textInput() ?>

    <div class="form-group field-requerimientodetalle-ro col-md-6">
      <label class="control-label" for="requerimientodetalle-ro">Ro</label>
      <input type="text" id="requerimientodetalle-ro" class="form-control" name="RequerimientoDetalle[ro]">
      <div class="help-block"></div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
      <?= $form->field($model, 'especificacion_tecnica')->widget(\yii\redactor\widgets\Redactor::className(['widgetContainer'=>['class'=>'col-sm-9'],]))->label('Especificación Técnica') ?>
    </div>


<!--    <div class="form-group field-requerimientodetalle-especificacion_tecnica">
      <label class="control-label" for="requerimientodetalle-especificacion_tecnica">Especificacion Tecnica</label>
      <textarea id="requerimientodetalle-especificacion_tecnica" class="form-control" name="RequerimientoDetalle[especificacion_tecnica]" rows="6"></textarea>
      <div class="help-block"></div>
    </div>-->


    <div class="clearfix"></div>
    <div class="col-md-6">
      <?= $form->field($model, 'tipo_garantia_id')->dropDownList($array_metacodigo, ['prompt'=>'Seleccionar'])->label('Tipo de Garantia') ?>
    </div>


<!--    <div class="form-group field-requerimientodetalle-tipo_garantia_id">
      <label class="control-label" for="requerimientodetalle-tipo_garantia_id">Tipo de Garantia</label>
      <input type="text" id="requerimientodetalle-tipo_garantia_id" class="form-control" name="RequerimientoDetalle[tipo_garantia_id]">
      <div class="help-block"></div>
    </div>-->

    <?php //= $form->field($model, 'garantia_cantidad')->textInput() ?>

    <div class="form-group field-requerimientodetalle-garantia_cantidad col-md-6">
      <label class="control-label" for="requerimientodetalle-garantia_cantidad">Cantidad de la Garantía</label>
      <input type="text" id="requerimientodetalle-garantia_cantidad" class="form-control" name="RequerimientoDetalle[garantia_cantidad]">
      <div class="help-block"></div>
    </div>
    <div class="clearfix"></div>
    <?php //= $form->field($model, 'tiempo_entrega')->textInput() ?>
    <div class="form-group field-requerimientodetalle-tiempo_entrega col-md-4">
      <label class="control-label" for="requerimientodetalle-tiempo_entrega">Tiempo de Entrega</label>
      <input type="text" id="requerimientodetalle-tiempo_entrega" class="form-control" name="RequerimientoDetalle[tiempo_entrega]">
      <div class="help-block"></div>
    </div>
    <div class="col-md-4">
      <?= $form->field($model, 'lugar_entrega')->dropDownList($array_ubicaciones, ['prompt'=>'Seleccionar'])->label('Lugar de Entrega') ?>
    </div>
    <div class="col-md-4">
      <?= $form->field($model, 'fecha_entrega')->widget(DatePicker::classname(),[
              'name' => 'fecha_fin_widget',
              'removeButton' => false,
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'yyyy-mm-dd']])->label('Fecha de Entrega');
      ?>
    </div>
    <div class="clearfix"></div>

<!--    <div class="form-group field-requerimientodetalle-lugar_entrega">
      <label class="control-label" for="requerimientodetalle-lugar_entrega">Lugar de Entrega</label>
      <input type="text" id="requerimientodetalle-lugar_entrega" class="form-control" name="RequerimientoDetalle[lugar_entrega]" maxlength="255">
      <div class="help-block"></div>
    </div>-->



<!--    <div class="form-group field-requerimientodetalle-fecha_entrega">
      <label class="control-label" for="requerimientodetalle-fecha_entrega">Fecha Entrega</label>
      <input type="text" id="requerimientodetalle-fecha_entrega" class="form-control" name="RequerimientoDetalle[fecha_entrega]">
      <div class="help-block"></div>
    </div>-->

    <?php //= $form->field($model, 'forma_pago')->textarea(['rows' => 6]) ?>

    <div class="form-group field-requerimientodetalle-forma_pago col-md-12">
      <!--
      <label class="control-label" for="requerimientodetalle-forma_pago">Forma de Pago</label>
      <textarea id="requerimientodetalle-forma_pago" class="form-control" name="RequerimientoDetalle[forma_pago]" rows="6"></textarea>
      -->

      <div class="panel panel-default">
        <div class="panel-heading">Forma de pagos</div>
        <div class="panel-body">
          <div class="btn btn-default pull-right btn-agregar-forma-pago"><span class="glyphicon glyphicon-plus "></span></div>
          <table id="tabla_forma_pago" class="table">
              <thead>
                <th>#</th>
                <th>Descripción</th>
                <th>Tiempo</th>
                <th>%</th>
                <th>Condición</th>
                <th>Acciones  </th>
              </thead>
              <tbody>
                <tr id="detalle_forma_pago_1">
                </tr>
              </tbody>
          </table>
        </div>
      </div>

      <div class="help-block"></div>
    </div>
    <div class="col-md-12">
      <?= $form->field($model, 'resumen_especificacion_tecnica')->widget(\yii\redactor\widgets\Redactor::className())->label('Resumen de Especificación Técnica') ?>
    </div>


<!--    <div class="form-group field-requerimientodetalle-resumen_especificacion_tecnica">
      <label class="control-label" for="requerimientodetalle-resumen_especificacion_tecnica">Resumen Especificacion Tecnica</label>
      <textarea id="requerimientodetalle-resumen_especificacion_tecnica" class="form-control" name="RequerimientoDetalle[resumen_especificacion_tecnica]" rows="6"></textarea>
      <div class="help-block"></div>
    </div>-->
    <div class="col-md-12">
      <?= $form->field($model, 'otras_caractaristicas')->widget(\yii\redactor\widgets\Redactor::className())->label('Especificación Técnica') ?>
    </div>


<!--    <div class="form-group field-requerimientodetalle-otras_caractaristicas">
      <label class="control-label" for="requerimientodetalle-otras_caractaristicas">Otras Caractaristicas</label>
      <textarea id="requerimientodetalle-otras_caractaristicas" class="form-control" name="RequerimientoDetalle[otras_caractaristicas]" rows="6"></textarea>
      <div class="help-block"></div>
    </div>-->

    <?php //= $form->field($model, 'forma_entrega')->textInput() ?>

    <div class="form-group field-requerimientodetalle-forma_entrega col-md-12">
      <label class="control-label" for="requerimientodetalle-forma_entrega">Forma de Entrega</label>
      <input type="text" id="requerimientodetalle-forma_entrega" class="form-control" name="RequerimientoDetalle[forma_entrega]">
      <div class="help-block"></div>
    </div>

    <?php //= $form->field($model, 'anio_fabricacion')->textInput() ?>

    <div class="form-group field-requerimientodetalle-anio_fabricacion col-md-6">
      <label class="control-label" for="requerimientodetalle-anio_fabricacion">Año de Fabricación</label>
      <input type="text" id="requerimientodetalle-anio_fabricacion" class="form-control" name="RequerimientoDetalle[anio_fabricacion]">
      <div class="help-block"></div>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'lugar_fabricacion')->dropDownList($array_ubicaciones, ['prompt'=>'Seleccionar'])->label('Lugar de Fabricación') ?>
    </div>


<!--    <div class="form-group field-requerimientodetalle-lugar_fabricacion">
      <label class="control-label" for="requerimientodetalle-lugar_fabricacion">Lugar de Fabricacion</label>
      <input type="text" id="requerimientodetalle-lugar_fabricacion" class="form-control" name="RequerimientoDetalle[lugar_fabricacion]" maxlength="255">
      <div class="help-block"></div>
    </div>-->

    <?php //= $form->field($model, 'staff_area_id')->textarea(['rows' => 6]) ?>




	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
$('body').on('change', '.linea-presupuestal', function (e) {
    e.preventDefault();

    var linea_nivel_id = $(this).val();

    $.ajax({
        url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento-detalle/get-linea-presupuesto-json',
        async:false,
        data:{linea_nivel_id:linea_nivel_id},
        method: 'POST',
        dataType:'JSON',
        beforeSend:function()
        {

        },
        success:function(result)
        {
          if(result==0){
            $('#requerimientodetalle-descripcion').val('');
            $('#requerimientodetalle-cantidad').val('');
            $('#requerimientodetalle-costo_unitario').val('');
            $('#requerimientodetalle-unidad_medida').val('');
            $('#requerimientodetalle-monto_total').val('');

            alert('No se tiene información detallada del item');

          }else if(result){
            var precio_unitario_ro = (parseFloat(result.precio_unitario_ro))?parseFloat(result.precio_unitario_ro):0.00;
            var precio_unitario_rooc = (parseFloat(result.precio_unitario_rooc))?parseFloat(result.precio_unitario_rooc):0.00;
            var precio_2 = 0.00;
            precio_2 = precio_unitario_ro + precio_unitario_rooc;
            console.log(precio_unitario_ro);
            var promedio_precio_unitario = (precio_unitario_ro!=0 && precio_unitario_rooc!=0 ) ? (precio_unitario_ro + precio_unitario_rooc)/2 :  precio_2 ;

            var cantidad = parseInt(result.avance_total);
            var total = promedio_precio_unitario*cantidad;
            $('#requerimientodetalle-descripcion').val(result.descripcion);
            $('#requerimientodetalle-cantidad').val(result.avance_total);
            $('#requerimientodetalle-costo_unitario').val( promedio_precio_unitario);
            $('#requerimientodetalle-unidad_medida').val(result.unidad_medida_id);
            $('#requerimientodetalle-monto_total').val(total);
          }

          //$.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
        },
        error:function(){

            alert('Error al realizar la obtención de información');
        }
    });
    return true;

});
</script>
