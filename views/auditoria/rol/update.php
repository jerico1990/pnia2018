<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rol */
?>
<div class="rol-update">

    <?= $this->render('_form_update', [
        'model' => $model,
        'proceso_searchModel' => $proceso_searchModel,
        'proceso_dataProvider' => $proceso_dataProvider
    ]) ?>

</div>
