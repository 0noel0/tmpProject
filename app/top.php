<?php

require '../util/Prototype.php';

$name = session('get', 'name');
$lastName = session('get', 'lastName');
$isAdmin = $name == '-' && $lastName = '-' ? true : false;

$userName = $name.' '.$lastName;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../assets/images/favicon.png" rel="shortcut icon">

        <title>Sistema de Cotizaciones</title>

        <link href="../assets/bs3/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/bootstrap-reset.css" rel="stylesheet">
        <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="../assets/css/style.css" rel="stylesheet">
        <link href="../assets/css/style-responsive.css" rel="stylesheet" />
        <link href="../assets/js/file-uploader/css/jquery.fileupload.css" rel="stylesheet">
        <link href="../assets/js/file-uploader/css/jquery.fileupload-ui.css" rel="stylesheet">
        <noscript>
            <link href="../assets/js/file-uploader/css/jquery.fileupload-noscript.css" rel="stylesheet">
        </noscript>
        <noscript>
            <link href="../assets/js/file-uploader/css/jquery.fileupload-ui-noscript.css" rel="stylesheet">
        </noscript>
        <link href="../assets/js/advanced-datatable/css/demo_page.css" rel="stylesheet">
        <link href="../assets/js/advanced-datatable/css/demo_table.css" rel="stylesheet">
        <link href="../assets/js/data-tables/DT_bootstrap.css" rel="stylesheet">

        <script src="../assets/js/jquery.js"></script>

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <section id="container" >
            <header class="header fixed-top clearfix">
                <div class="brand text-center">
                    <a href="./" class="logo" style="width: 100%;">
                        <p style="color: white;font-weight: bold;">Sistema de Cotizaciones</p>
                    </a>
                    <div class="sidebar-toggle-box">
                        <div class="fa fa-bars"></div>
                    </div>
                </div>
                <div class="nav notify-row" id="top_menu">
                </div>
                <div class="top-nav clearfix">
                    <ul class="nav pull-right top-menu">
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="username"><?php echo $isAdmin ? 'Administrador' : $userName; ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <li><a href="./logout.php"><i class="fa fa-key"></i>Cerrar sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </header>
            <aside>
                <div id="sidebar" class="nav-collapse">
                    <div class="leftside-navigation">
                        <ul class="sidebar-menu" id="nav-accordion">
                            <li>
                                <a href="./">
                                    <i class="fa fa-home"></i>
                                    <span>Home</span>
                                </a>
                            </li>
                            <?php if($isAdmin){ ?>
                            <li class="sub-menu">
                                <a href="./users">
                                    <i class="fa fa-users"></i>
                                    <span>Administrar usuarios</span>
                                </a>
                            </li>
                            <?php } ?>
                            <li class="sub-menu">
                                <a href="./import">
                                    <i class="fa fa-laptop"></i>
                                    <span>Importar datos mediante Excel</span>
                                </a>
                            </li>
                            <li class="sub-menu">
                                <a href="./sale">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Nueva compra</span>
                                </a>
                            </li>
                        </ul>
                    </div>        
                </div>
            </aside>
            <section id="main-content">
                <section class="wrapper">