<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Meta */
$model->estado_regitro = 1;
?>
<div class="meta-create">
    <?= $this->render('_form', [
        'model' => $model,
        'is_update' => false,
        'array_unidad_medida' => $array_unidad_medida
    ]) ?>
</div>
