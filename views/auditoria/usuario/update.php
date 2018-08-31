<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
    $model->password_hash = '';
?>
<div class="usuario-update">

    <?= $this->render('_form_update', [
        'model' => $model,
        'rol_searchModel' => $rol_searchModel,
        'rol_dataProvider' => $rol_dataProvider
    ]) ?>

</div>