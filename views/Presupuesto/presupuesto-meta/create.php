<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoMeta */

?>
<div class="presupuesto-meta-create">
    <?= $this->render('_form', [
        'model' => $model,
        'periodos' => [],
        'is_update' => false,
    ]) ?>
</div>
