<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\StaffArea */
?>
<div class="staff-area-view">
 
 <?php 

    $attributes = [
            //'staff_area_id',
            'codigo',
            'descripcion',
            'cargo',
            //'responsable',
            'area_superior',
            'personaResponsable.nombres', //cuando es de otra tabla
        ];
    
    if (strcmp('',$model->area_superior) != 0) {
        $attributes[] = [
                'label' => 'Área superior',
                'attribute' => 'areaSuperior.descripcion',
        ];
    }

 ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>
