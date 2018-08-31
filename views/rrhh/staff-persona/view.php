<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\StaffPersona */
?>
<div class="staff-persona-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'staff_persona_id',
            'nombres',
            'apellido_paterno',
            'apellido_materno',
            'codigo_pnia',
            'ruc',
            'cuenta_bancaria',
            'nombreStaffArea',
            'nombreBanco',
        ],
    ]) ?>

</div>
