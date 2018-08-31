<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoVersion */
?>
<div class="presupuesto-version-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nro_version',
            'fecha',
            'textoEstatus',
        ],
    ]) ?>

</div>
