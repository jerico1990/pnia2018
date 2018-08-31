<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoCabecera */

?>
<div class="presupuesto-cabecera-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_partidas' => $array_partidas,
        'array_padres'   => $array_padres,
    ]) ?>
</div>
