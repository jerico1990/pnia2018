<?php
   namespace app\controllers\Auditoria;
   use Yii;
   use yii\web\Controller;
   use app\models\Auditoria\Usuario;
   class MyAuthenticationController extends Controller
   {
       public function actionLogin()
       {
           $error = null;
           $username = Yii::$app->request->post('username', null);
           $password = Yii::$app->request->post('password', null);
           $user = Usuario::findOne(['alias' => $username ]);
           if(($username!=null)&&($password!=null))
           {
               if($user != null)
               {
                   if($user->validatePassword($password))
                   {
                       Yii::$app->user->login($user);
                   }
                   else {
                       $error = 'Validación de contraseña fallida!';
                     }
                   } else {
                   $error = 'Usuario no encontrado(a)';
               }
             }
             // */
           return $this->render('login', ['error' => $error]);
       }
       public function actionLogout()
       {
           Yii::$app->user->logout();
           return $this->redirect(['login']);
       }
}