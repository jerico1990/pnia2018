<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoMeta */
?>
<div class="presupuesto-meta-update">

    <?= $this->render('_form', [
        'model' => $model,
        'periodos' => $periodos,
        'is_update' => true,
    ]) ?>

</div>
