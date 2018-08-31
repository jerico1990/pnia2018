<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\PniaEntFinanciera */
?>
<div class="pnia-ent-financiera-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'pnia_ent_financiera_id',
            //'tipo_entidad',
            'tipoEntidadFinanciera.descripcion',
            'razon_social',
            'cuenta_bancaria',
        ],
    ]) ?>

</div>
