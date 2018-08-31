<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Requerimiento */

?>
<div class="requerimiento-create">
    <?= $this->render('_form', [
        'model' => $model,
        'array_tipo_requerimiento'=>$array_tipo_requerimiento,
        'flag_action'=>$flag_action,
		'model_documento_pnia' => $model_documento_pnia,
    ]) ?>
</div>
