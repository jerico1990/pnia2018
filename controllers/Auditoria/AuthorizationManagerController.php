<?php

namespace app\controllers\Auditoria;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Auditoria\Usuario;
use app\models\Auditoria\LoginForm;
use app\models\Auditoria\AuthorizationManager;

use app\models\Auditoria\RolProceso;
use app\models\Auditoria\RolUsuario;
use app\models\Auditoria\Rol;

/*
 * In this example, we will create a user permissions management
system from scratch, based on RBAC. We will create a new controller
named AuthorizationManagerController in basic/controllers/
AuthorizationManagerController.php that will display all the users
and all the available permissions and roles from the database. This example
is based on the user database table already used in the previous paragraphs.

 */
     

class AuthorizationManagerController extends Controller
{
    /*
 * The first method to create in this controller is initializeAuthorizations(),
which has to initialize all the available authorizations in the system:
 */

    /*
     * At the top of this method, we created a permissions and roles list, then we assigned
them to the Yii authorization component. Take care to ensure that, after calling this
method for the first time, you check whether any children already exist by calling
the hasChild method on every addChild() insert attempt.
     */
//     public function initializeAuthorizations()
//     {
//         $auth = Yii::$app->authManager;
        
//         $ListaPermisos = new RolProceso();
//         $ListaCompletaPermisos = $ListaPermisos->getListaDePermisos();
        
//         $ListaDeRolesYPermisos = new RolProceso();
//         $ListaRoles = $ListaDeRolesYPermisos->getListaDeRolesYPermisos();

//         $permissions = $ListaCompletaPermisos;
//         $roles = $ListaRoles;
//         /*
//         $permissions = [
//             'createReservation' => array('desc' => 'Create a reservation'),
//             'updateReservation' => array('desc' => 'Update reservation'),
//             'deleteReservation' => array('desc' => 'Delete reservation'),

//             'createRoom' => array('desc' => 'Create a room'),
//             'updateRoom' => array('desc' => 'Update room'),
//             'deleteRoom' => array('desc' => 'Delete room'),
            
//             'createCustomer' => array('desc' => 'Create a customer'),
//             'updateCustomer' => array('desc' => 'Update customer'),
//             'deleteCustomer' => array('desc' => 'Delete customer'),
//         ];*/
//         /*
//         $roles = [
//             'operator' => array('createReservation', 'createRoom', 'createCustomer'),
//         ];*/

//         // Add all permissions/actions
//         foreach($permissions as $keyP=>$valueP)
//         {
//             if($auth->getPermission($keyP))
//             {
//                 continue;
//             }
//             else
//             {
//                 $p = $auth->createPermission($keyP);
//                 $p->description = $valueP['desc'];
//                 $auth->add($p);
                
//                 // add "operator" role and give this role the  "createReservation" permission
//                 $r = $auth->createRole('role_'.$keyP);
//                 $r->description = $valueP['desc'];
//                 $auth->add($r);
//                 if( false == $auth->hasChild($r, $p)) 
//                         $auth->addChild($r, $p);
//             }

//         }
        
//          //Add all roles
//         //verifica que no hayan repetidos
//         foreach($roles as $keyR=>$valueR)
//         {
//             $r = $auth->createRole($keyR);
//             $r->description = $keyR;
            
//             //TO DO: TENER CUIDADO EN ESTE CODIGO
//             if($auth->getRole($keyR))
//             {
//                 foreach($valueR as $permissionName)
//                 {
//                     if( false == $auth->hasChild($r, $auth->getPermission($permissionName))) 
//                             $auth->addChild($r, $auth->getPermission($permissionName));
//                 }
//                 continue;
//             }
//             else
//             {  
//                 $auth->add($r);
//             }
//         }
        
//         //Add all permissions to admin role
// //        if(!$auth->getRole('adminTotal'))
// //        {
// //            $r = $auth->createRole('adminTotal');
// //            $r->description = 'adminTotal';
// //            $auth->add($r);
// //            foreach($permissions as $keyP=>$valueP)
// //            {
// //                if( true === $auth->hasChild($r, $auth->getPermission($keyP))) 
// //                {
// //                        $auth->addChild($r,$auth->getPermission($keyP));
// //                }
// //            }
// //        }
//     }
        
    
    /*
     * Next, we can create actionIndex(), which launches the previous initialize
authorizations, getting all the users and populating an array with all the permissions
assigned to every user. This is the content of the actionIndex() method:
     */
    public function actionIndex()
    {
        $auth = new AuthorizationManager();
       

        // Initialize authorizations
        $auth->initializeAuthorizations();
        // Get all users
        $users = Usuario::find()->all();

        // Initialize data
        $rolesAvailable = $auth->getRoles();
        $rolesNamesByUser = [];

        // For each user, fill $rolesNames with name of roles assigned to user
        foreach($users as $user)
        {
            $rolesNames = [];

            $roles = $auth->getRolesByUser($user->id);
            foreach($roles as $r)
            {
                $rolesNames[] = $r->name;
            }

            $rolesNamesByUser[$user->id] = $rolesNames;
        }

        return $this->render('index', ['users' => $users,
        'rolesAvailable' => $rolesAvailable, 'rolesNamesByUser' =>
        $rolesNamesByUser]);
   }
   
   //Now we must create the last two actions:
   // add a role and revoke a role to the user:
   
   /***
    * Agrega el rol al usuario en Authmanager, pero tambien lo guarda en la tabal roles_usuario
    * TO DO: no funcionara si no hay ningun usuario logeado por el grabado de beforeSave();
    */
   public function actionAddRole($userId, $roleName)
    {
        $auth = Yii::$app->authManager;

        $auth->assign($auth->getRole($roleName), $userId);
        
        
        $model = new RolUsuario();
        
        $rol = Rol::findOne(['nombre' => $roleName]);
        
     
        //verifica que rol exista en la BD, en caso de que se este asignando un permiso directamente
        if($rol)
        {
            $model->usuario_id = $userId;
            $model->rol_id = $rol->rol_id;
            $model->save();  
        }
        
        
        return $this->redirect(['index']);
    }

    public function actionRemoveRole($userId, $roleName)
    {
        $auth = Yii::$app->authManager;

        $auth->revoke($auth->getRole($roleName), $userId);
        
        //para quitar el registro de la DB con yii2
        $rol = Rol::findOne(['nombre' => $roleName]);
        if($rol)
        {
            $rolesUsuario = RolUsuario::findOne(['usuario_id' => $userId, 'rol_id' => $rol->rol_id]);
            $rolesUsuario->delete();
        }
        

        return $this->redirect(['index']);
    }
}
