<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoVersion */
?>
<div class="presupuesto-version-update">

    <?= $this->render('_form', [
        'model' => $model,
        'array_versiones_previas' => $array_versiones_previas,
    ]) ?>

</div>
