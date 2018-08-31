<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Viatico\ArbolArea */

?>
<div class="arbol-area-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_lista_areas' => $array_lista_areas,
        'array_presupuesto_raiz' => $array_presupuesto_raiz,
    ]) ?>
</div>
