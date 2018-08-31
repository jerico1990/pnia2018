<?php

use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Modulo */
?>
<div class="modulo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'modulo_id',
            'nombre',
            'descripcion',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
             //'creado_por',
        ],
    ]) ?>

</div>



<?php 
?>

