<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\Presupuesto\CategoriaProducto;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoCabecera */
/* @var $form yii\widgets\ActiveForm */
?>


<script>
    function ocultarNumeracion() {
        var cabecera_padre = document.getElementById('presupuestocabecera-presupuesto_cabecera_padre_id');
        //var campo_numeracion = document.getElementById("segmento_numeracion");
        var campo_block_nivel_1 = document.getElementById("block_nivel_1");
        var valor = cabecera_padre.value;

        if (valor == 0){
            //campo_numeracion.style.display = "block";
            campo_block_nivel_1.style.display = "block";
        }else{
            //campo_numeracion.style.display = "none";
            campo_block_nivel_1.style.display = "none";
            $.post("<?= \yii\helpers\Url::base() ?>/Presupuesto/presupuesto-cabecera-final/verificar-nivel",
                {
                    id: valor
                }, function (data) {
                    //alert('valor: '+valor+' nivel: '+data['nivel']+' show: '+data['show'][0]+' hide: '+data['hide'][0]);
                    data['hide'].forEach(ocultar);
                    data['show'].forEach(mostrar);
                }
            );
        }
    }

    function mostrar(item) {
        var div_oculta = document.getElementById('block_nivel_' + item);
        div_oculta.style.display = "block";
    }
    function ocultar(item) {
        var div_oculta = document.getElementById('block_nivel_'+item);
        div_oculta.style.display = "none";
    }
</script>

<div class="presupuesto-cabecera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'presupuesto_cabecera_padre_id')->dropDownList($array_padres,['prompt'=>'Ninguno','onchange'=>'ocultarNumeracion()']) ?>
    <?php if($isUpdate){ $model->nombre_linea = $model->nombre_linea;}?>
    <?= $form->field($model, 'nombre_linea')->textInput()->label('Descripción') ?>

    <?php if($isUpdate){
        $nivel = ($model->nivel);
        switch ($nivel){
            case 1:
                echo $form->field($model, 'numeracion_linea')->textInput()->label('Numeración (Proyecto)');
                echo $form->field($model, 'objetivo_estrategico_id')->dropDownList(\app\models\Presupuesto\ObjetivoEstrategico::getComboBoxItems(),['prompt'=>'Ninguno']);
                echo $form->field($model, 'accion_estrategica_id')->dropDownList(\app\models\Presupuesto\AccionEstrategica::getComboBoxItems(),['prompt'=>'Ninguna']);
                break;
            case 2:
                echo $form->field($model,'presupuesto_contrato_id')->dropDownList(\app\models\Presupuesto\PresupuestoContrato::getComboBoxItems(),['prompt'=>'Ninguno']);
                break;
            case 3:
                echo $form->field($model,'codigo_meta_id')->dropDownList(\app\models\Presupuesto\CodigoMeta::getComboBoxItems(),['prompt'=>'Ninguno']);
                break;
            case 5:
                if ($model->presupuestoContrato->esBancoMundial()){
                    $model->temp_categoria = $model->categoria_producto_id;
                    echo $form->field($model,'temp_categoria')->dropDownList(CategoriaProducto::getComboBoxItems(1),['prompt'=>'Ninguna']);
                }else{
                    $model->temp_producto = $model->categoria_producto_id;
                    echo $form->field($model,'temp_producto')->dropDownList(CategoriaProducto::getComboBoxItems(0),['prompt'=>'Ninguno']);
                }
            case 6:
                echo "<fieldset><legend>Meta Financiera</legend>";
                echo $form->field($model,'meta_financiera_descripcion')->textInput()->label('Descripción');
                echo "<table width='100%'><tr><td>";
                echo $form->field($model,'meta_financiera_avance_actual')->textInput()->label('Alcance Actual');
                echo "</td><td>";
                echo $form->field($model,'meta_financiera_avance_total')->textInput()->label('Alcance Total');
                echo "</td><td>";
                echo $form->field($model,'meta_financiera_unidad_medida_id')->textInput()->label('Unidad de Medida');
                echo "</td></tr></table>";

                echo "<table width='100%'><tr><td>";
                echo $form->field($model,'meta_financiera_precio_unitario_ro')->textInput();
                echo "</td><td>";
                echo $form->field($model,'meta_financiera_precio_unitario_rooc')->textInput();
                echo "</td></tr></table>";

                echo "<table width='100%'><tr><td>";
                echo $form->field($model,'meta_financiera_monto_total_ro')->textInput();
                echo "</td><td>";
                echo $form->field($model,'meta_financiera_monto_total_rooc')->textInput();
                echo "</td></tr></table>";
                echo "</fieldset>";

                //echo $form->field($model,'meta_fisica_id')->textInput();

                echo "<fieldset><legend>Meta Fisica</legend>";
                echo $form->field($model,'meta_fisica_descripcion')->textInput()->label('Descripción');
                echo "<table width='100%'><tr><td>";
                echo $form->field($model,'meta_fisica_avance_actual')->textInput();
                echo "</td><td>";
                echo $form->field($model,'meta_fisica_avance_total')->textInput();
                echo "</td><td>";
                echo $form->field($model,'meta_fisica_unidad_medida_id')->textInput();
                echo "</td></tr></table>";
                echo "</fieldset>";

                echo $form->field($model, 'partida_id')->dropDownList($array_partidas,['prompt'=>'Ninguno']);
                break;
        }
    }else{ ?>

        <div id="block_nivel_1">

            <?= $form->field($model,'tipo_presupuesto')->dropDownList([1=>'Pip1',2=>'Pip2',3=>'Pip3'])?>

            <?= $form->field($model, 'indice_linea')->textInput()->label('Numeración (Proyecto)') ?>

            <!--<?= $form->field($model, 'numeracion_linea')->textInput()->label('Numeración (Proyecto)') ?>-->

            <?= $form->field($model, 'objetivo_estrategico_id')->dropDownList(\app\models\Presupuesto\ObjetivoEstrategico::getComboBoxItems(),['prompt'=>'Ninguno']) ?>

            <?= $form->field($model, 'accion_estrategica_id')->dropDownList(\app\models\Presupuesto\AccionEstrategica::getComboBoxItems(),['prompt'=>'Ninguna']) ?>
        </div>

        <div id="block_nivel_2" style="display: none" >
            <?= $form->field($model,'presupuesto_contrato_id')->dropDownList(\app\models\Presupuesto\PresupuestoContrato::getComboBoxItems(),['prompt'=>'Ninguno']) ?>
        </div>

        <div id="block_nivel_3" style="display: none" >
            <?= $form->field($model,'codigo_meta_id')->dropDownList(\app\models\Presupuesto\CodigoMeta::getComboBoxItems(),['prompt'=>'Ninguno']) ?>
        </div>

        <!-- sub vistas de 5 -->
        <div id="block_nivel_categoria" style="display: none" >
            <?= $form->field($model,'temp_categoria')->dropDownList(CategoriaProducto::getComboBoxItems(1),['prompt'=>'Ninguna']) ?>
        </div>
        <div id="block_nivel_producto" style="display: none" >
            <?= $form->field($model,'temp_producto')->dropDownList(CategoriaProducto::getComboBoxItems(0),['prompt'=>'Ninguno']) ?>
        </div>
        <!--- LVL 6,8,9 corresponden a este segmento-->
        <div id="block_nivel_6" style="display: none" >

            <!-- <?= $form->field($model,'meta_financiera_id')->textInput()?>
            <?= $form->field($model,'meta_fisica_id')->textInput() ?> -->
            <?php

            echo "<fieldset><legend>Meta Financiera</legend>";
            //echo $form->field($model,'meta_financiera_id')->textInput();
            echo $form->field($model,'meta_financiera_descripcion')->textInput()->label('Descripción');
            echo "<table width='100%'><tr><td>";
            echo $form->field($model,'meta_financiera_avance_actual')->textInput()->label('Alcance Actual');
            echo "</td><td>";
            echo $form->field($model,'meta_financiera_avance_total')->textInput()->label('Alcance Total');
            echo "</td><td>";
            echo $form->field($model,'meta_financiera_unidad_medida_id')->dropDownList(\app\models\Presupuesto\UnidadMedida::getComboBoxItems())->label('Unidad de Medida');

            echo "</td></tr></table>";

            echo "<table width='100%'><tr><td>";
            echo $form->field($model,'meta_financiera_precio_unitario_ro')->textInput();
            echo "</td><td>";
            echo $form->field($model,'meta_financiera_precio_unitario_rooc')->textInput();
            echo "</td></tr></table>";

            echo "<table width='100%'><tr><td>";
            echo $form->field($model,'meta_financiera_monto_total_ro')->textInput();
            echo "</td><td>";
            echo $form->field($model,'meta_financiera_monto_total_rooc')->textInput();
            echo "</td></tr></table>";
            echo "</fieldset>";

            //echo $form->field($model,'meta_fisica_id')->textInput();
            echo "<fieldset><legend>Meta Fisica</legend>";
            echo $form->field($model,'meta_fisica_descripcion')->textInput()->label('Descripción');
            echo "<table width='100%'><tr><td>";
            echo $form->field($model,'meta_fisica_avance_actual')->textInput()->label('Alcance Actual');
            echo "</td><td>";
            echo $form->field($model,'meta_fisica_avance_total')->textInput()->label('Alcance Total');
            echo "</td><td>";
            echo $form->field($model,'meta_fisica_unidad_medida_id')->dropDownList(\app\models\Presupuesto\UnidadMedida::getComboBoxItems())->label('Unidad de Medida');
            echo "</td></tr></table>";
            echo "</fieldset>";
            ?>
            <?= $form->field($model, 'partida_id')->dropDownList($array_partidas,['prompt'=>'Ninguno']) ?>
        </div>

    <?php } ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

