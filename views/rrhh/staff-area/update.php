<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\StaffArea */
?>
<div class="staff-area-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_lista_areas' => $array_lista_areas,
        'array_personas' => $array_personas,
    ]) ?>

</div>
