<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoCartaFianza */
?>
<div class="contrato-carta-fianza-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo_interno',
            [
                'label' => 'Entidad emisora',
                'attribute' => 'entidadEmisora.razon_social',
            ],
            [
                'label' => 'Entidad afianzada',
                'attribute' => 'entidadAfianzada.razon_social',
            ],
            'contrato',
            'periodo_inicio',
            'periodo_fin',
            'monto',

        ],
    ]) ?>

</div>
