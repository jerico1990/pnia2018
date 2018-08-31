<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\Models\Mensaje;

$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        input[type=cute-input] {
            display: block;
            width: 91px;
            height:20px;
            padding: 6px 12px;
            font-size: 12px;
            line-height: 1.42857143;
            color: #1b6d85;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .pestanha-on {
            background: rgb(69,122,178);
            color: white;
            border-radius: 6px     6px      0           0;
            font-size: 14px;
            float: top;
            width: 200px;
        }

        .pestanha-off {
            background: rgb(69,122,178);
            opacity: 0.8;
            color: white;
            border-radius: 6px     6px      0           0;
            font-size: 14px;
            float: top;
            width: 200px;
        }
    </style>
</head>

<?php 

    /// segmento de login y creación de la barra de menus
    $menuOptions = [];
    $welcomeMessage = "Primero";
    $userMessage    = "Iniciar Sesión";
    $mensajes = [];
    $isLogged = !Yii::$app->user->isGuest; //isset($_SESSION['menuOptions']);
    $logoutUrl = Url::base() . "/site/logout";


    /// variables de carga para mensajeria
    $max_num_mensajes = 4;  // maximo numero de mensajes que hacen display
    $num_mensajes = 0;     // Se debe cargar esde la BD los mensajes

    if ($isLogged) {

        $welcomeMessage = "Bienvenido(a),";
        $userMessage    = Yii::$app->user->identity->alias;//nombre;
        $mensajes = Yii::$app->user->identity->getMensajesPara()->All();
        $num_mensajes = count($mensajes);

        $menuOptions[] = ["label" => 'Home ('.$userMessage.')', "url" => $rootUrl  = Url::base(), "icon" => "home"];
        
        
        /// aqui si se desea que recargue cada vez que carga la pagina
        $myItems = Yii::$app->user->identity->getRolMenuItems(); 
        
        /// aqui para que se cargue solo con la Sesión 
        /*$myItems = [];
        if( isset($_SESSION['menuOptions']) && count($_SESSION['menuOptions']) > 0){
           $myItems = $_SESSION['menuOptions']; 
        } else {
            $_SESSION['menuOptions'] = Yii::$app->user->identity->getRolMenuItems(); 
            $myItems = $_SESSION['menuOptions'];// Yii::$app->user->identity->getRolMenuItems(); 
        }// */
        /// aqui para que se cargue solo con la Sesión 

    foreach ($myItems as $item ) {
            $menuOptions[] = $item;
        }
        $menuOptions[] = ["label"=> "Cerrar Sesión", "url" => $logoutUrl ,"icon" => "user"];

    } else {
        $menuOptions = [["label" => $userMessage, "url" => $rootUrl  = Url::base(), "icon" => "home"],];
        $_SESSION['menuOptions'] = [];
    }
?>

<style>
    body.container{ width: 100% !important; }
</style>

<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>

<!-- <div class = "container body">-->
<div class="container body" style="width : auto; display: inline-block;">
    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href=<?= '"'.Url::base().'"' ?> class="site_title">
                        
                        <?php 
                        $img = Url::base().'/icons/logo-pnia-blanco.png';
                        ?>
                    <center>
                        <img src = <?= '"'.$img.'"' ?> width = "50%" >
                        </center >
                    <!--     <span>SSA - PNIA</span> -->
                    </a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="http://placehold.it/128x128" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span><?php echo $welcomeMessage ?></span>
                        <h2><?php echo $userMessage ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => $menuOptions,
                            ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <!--
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Cerrar Sesión">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                -->

                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <?php if ($isLogged) { ?>
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="http://placehold.it/128x128" alt=""><?php echo $userMessage ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href=<?php echo Url::base() ?> >  Home</a>
                                    </li>
                                    <li><a href=<?php echo Url::base().'/Auditoria/usuario/custom-update?id='.Yii::$app->user->identity->id ?> >  Cambiar Contraseña</a>
                                    </li>
                                     <li><a href=<?php echo Url::base().'/Auditoria/usuario/reset-password?id='.Yii::$app->user->identity->id ?> >  Restablecer Contraseña</a>
                                    </li>
                                    <!--
                                    <li>
                                        <a href="javascript:;">
                                            <span class="badge bg-red pull-right">50%</span>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">Help</a>
                                    </li>
                                    -->
                                    <li><a href=<?php echo $logoutUrl ?>><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green"><?php echo $num_mensajes ?></span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                
                                <?php for ($i=0; $i < min($num_mensajes,$max_num_mensajes); $i++) { ?>
                                <li>
                                    <a>
                                      <span class="image"> <img src="http://placehold.it/128x128" alt="Profile Image" /> </span>
                                      <span>
                                            <span><?php echo $mensajes[$i]->getUsuarioDe()->one()->alias ?></span>
                                            <span class="time">3 mins ago</span>
                                      </span>
                                      <span class="message">
                                        <?php echo $mensajes[$i]->titulo ?>
                                      </span>
                                    </a>
                                </li>
                                <?php } ?>
                                
                                <li>
                                    <div class="text-center">
                                        <?php if ($num_mensajes > 0) { ?>
                                            <a href="/">
                                                <strong>Ver todos los mensajes y alertas </strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        <?php } else { ?>
                                            <strong> No tiene mensajes o alertas </strong>
                                        <?php } ?>
                                    </div>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">Sistema de Soporte Administrativo - PNIA
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>