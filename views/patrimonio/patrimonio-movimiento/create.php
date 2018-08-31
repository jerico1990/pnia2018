<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioMovimiento */

?>
<div class="patrimonio-movimiento-create">
    <?= $this->render('_form', [
        'model' => $model,
        'metacodigos' => $metacodigos,
        'ubicaciones' => $ubicaciones,
        'items' => $items,
        'user' => $user,
        'model_item' => $model_item,
    ]) ?>
</div>
