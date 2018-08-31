<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\rrhh\StaffPersona */

?>
<div class="staff-persona-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_entidades_financieras' => $array_entidades_financieras,
        'array_staff_areas' => $array_staff_areas,
    ]) ?>
</div>
