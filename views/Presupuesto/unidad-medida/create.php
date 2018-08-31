<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\UnidadMedida */
$model->estado_regitro = 1;
?>
<div class="unidad-medida-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
