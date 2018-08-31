<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Meta */
?>
<div class="meta-update">

    <?= $this->render('_form', [
        'model' => $model,
        'is_update' => true,
        'array_unidad_medida' => $array_unidad_medida
    ]) ?>

</div>
