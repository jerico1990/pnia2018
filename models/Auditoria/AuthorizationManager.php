<?php

namespace app\models\Auditoria;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Auditoria\Usuario;
use app\models\Auditoria\LoginForm;

use app\models\Auditoria\RolProceso;
use app\models\Auditoria\RolUsuario;
use app\models\Auditoria\Rol;

/**
 * This is the model class for table "modulo".
 *
 * @property int $modulo_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $actualizado_en
 * @property int $actualizado_por
 * @property string $creado_en
 * @property int $creado_por
 *
 * @property Usuario $actualizadoPor
 * @property Usuario $creadoPor
 * @property Proceso[] $procesos
 */
class AuthorizationManager extends \yii\db\ActiveRecord
{
    public function initializeAuthorizations()
    {
        $auth = Yii::$app->authManager;
        
        $ListaPermisos = new RolProceso();
        $ListaCompletaPermisos = $ListaPermisos->getListaDePermisos();
        
        $ListaDeRolesYPermisos = new RolProceso();
        $ListaRoles = $ListaDeRolesYPermisos->getListaDeRolesYPermisos();

        $permissions = $ListaCompletaPermisos;
        $roles = $ListaRoles;
        
        foreach($permissions as $keyP=>$valueP)
        {
            if($auth->getPermission($keyP))
            {
                continue;
            }
            else
            {
                $p = $auth->createPermission($keyP);
                $p->description = $valueP['desc'];
                $auth->add($p);
                
                // add "operator" role and give this role the  "createReservation" permission
                $r = $auth->createRole('role_'.$keyP);
                $r->description = $valueP['desc'];
                if(!$auth->getRole('role_'.$keyP))
                    $auth->add($r);
                if( false == $auth->hasChild($r, $p)) 
                        $auth->addChild($r, $p);
            }

        }
        
         //Add all roles
        //verifica que no hayan repetidos
        foreach($roles as $keyR=>$valueR)
        {
            $r = $auth->createRole($keyR);
            $r->description = $keyR;
            
            //TO DO: TENER CUIDADO EN ESTE CODIGO
            if($auth->getRole($keyR))
            {
                foreach($valueR as $permissionName)
                {
                    if( false == $auth->hasChild($r, $auth->getPermission($permissionName))) 
                            $auth->addChild($r, $auth->getPermission($permissionName));
                }
                continue;
            }
            else
            {  
                $auth->add($r);
            }
        }
        
        //Add all permissions to admin role
//        if(!$auth->getRole('adminTotal'))
//        {
//            $r = $auth->createRole('adminTotal');
//            $r->description = 'adminTotal';
//            $auth->add($r);
//            foreach($permissions as $keyP=>$valueP)
//            {
//                if( true === $auth->hasChild($r, $auth->getPermission($keyP))) 
//                {
//                        $auth->addChild($r,$auth->getPermission($keyP));
//                }
//            }
//        }
    }

//     public function initializeAuthorizations()
//     {
//         $auth = Yii::$app->authManager;
//         $auth->removeAllPermissions();
//         $ListaPermisos = new RolProceso();
//         $ListaCompletaPermisos = $ListaPermisos->getListaDePermisos();
        
//         $ListaDeRolesYPermisos = new RolProceso();
//         $ListaRoles = $ListaDeRolesYPermisos->getListaDeRolesYPermisos();

//         $permissions = $ListaCompletaPermisos;
//         $roles = $ListaRoles;

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
                
//                 $r = $auth->createRole('role_'.$keyP);
//                 $r->description = $valueP['desc'];
                
//                 if(!$auth->getRole('role_'.$keyP))
//                     $auth->add($r);
//                 if( false === $auth->hasChild($r, $p)) 
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
        
   /***
    * Agrega el rol al usuario en Authmanager, pero tambien lo guarda en la tabal roles_usuario
    * TO DO: no funcionara si no hay ningun usuario logeado por el grabado de beforeSave();
    */
   public function addRole($userId, $roleName)
    {
        $auth = Yii::$app->authManager;
        $nombre_rol = $auth->getRole($roleName);
        if($nombre_rol==null){
            $rol = $auth->createRole($roleName);
            $rol->description = $roleName;
            $auth->add($rol);
        }
        $auth->assign($auth->getRole($roleName), $userId);
        
        return;
    }

    public function removeRole($userId, $roleName)
    {
        $auth = Yii::$app->authManager;

        $auth->revoke($auth->getRole($roleName), $userId);

        return;
    }

    public function borrarTodosLosRoles($id){
        $auth = Yii::$app->authManager;
        $usuario = new Usuario();
        $rol = new Rol();
        if($usuario->findIdentity($id)){
            $auth->revokeAll($id);
        }
        if($rol->findById($id)){
            $auth->revokeAll($id);
            return "holass";
        }

        
    }

    public function removeAllPermissions(){
        $auth = Yii::$app->authManager;
        $auth->removeAllPermissions();
    }

    public function getRoles(){
        $auth = Yii::$app->authManager;

        return $auth->getRoles();
    }

    public function getRolesByUser($usuario_id){
        $auth = Yii::$app->authManager;

        return $auth->getRolesByUser($usuario_id);
    }
}
