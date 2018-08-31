<?php
   use \yii\bootstrap\ActiveForm;
   use \yii\helpers\Html;
   use \yii\bootstrap\Alert;
   
   if($error != null) {
       echo Alert::widget([ 'options' => [ 'class' => 'alert-danger'], 'body' => $error ]);
   }
   ?>
