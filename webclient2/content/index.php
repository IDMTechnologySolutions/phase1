<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>STUIS</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="../dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
         <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.1.3 -->
        <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <script src="../plugins/jQuery/jquery.jeditable.js"></script>
        <script src="../plugins/jQuery/jquery.validate.js"></script>
        <script src="../plugins/jQueryUI/jquery-ui-1.10.3.min.js"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="../plugins/datatables/jquery.dataTables.editable.js" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js" type="text/javascript"></script>
        <!-- Add menulink.js to load content through ajax  -->
        <script src="../js/menulink.js" type="text/javascript"></script>
        
        <script src="../js/general_functions.js" type="text/javascript" ></script>
        <!-- SlimScroll -->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='../plugins/fastclick/fastclick.min.js'></script> 
    </head>
    <!--
    BODY TAG OPTIONS:
    =================
    Apply one or more of the following classes to get the 
    desired effect
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |  
    |---------------------------------------------------------|
    
    -->
    <body class="skin-blue">
        <div class="wrapper">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="index2.html" class="logo"><b>IDM</b></a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- inner menu: contains the messages -->
                                        <ul class="menu">
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <!-- User Image -->
                                                        <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                                                    </div>
                                                    <!-- Message title and timestamp -->
                                                    <h4>                            
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <!-- The message -->
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li><!-- end message -->                      
                                        </ul><!-- /.menu -->
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li><!-- /.messages-menu -->

                            <!-- Notifications Menu -->
                            <li class="dropdown notifications-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- Inner Menu: contains the notifications -->
                                        <ul class="menu">
                                            <li><!-- start notification -->
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li><!-- end notification -->                      
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- Tasks Menu -->
                            <li class="dropdown tasks-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">9</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                        <!-- Inner menu: contains the tasks -->
                                        <ul class="menu">
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <!-- Task title and progress text -->
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <!-- The progress bar -->
                                                    <div class="progress xs">
                                                        <!-- Change the css width attribute to simulate progress -->
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->                      
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all tasks</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">Alexander Pierce</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                                        <p>
                                            Alexander Pierce - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Followers</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Alexander Pierce</p>
                            <!-- Status -->
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                    <!-- search form (Optional) -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->

                    <!-- Sidebar Menu -->

                    <?php
                  
                    require_once('../scripts/pdo_db.php');
                    $database = new core_db;
                    $hasil = $database->query('SELECT id as menu_item_id, parent_id as menu_parent_id, title as menu_item_name,concat("/webclient2",url)as url,menu_order,icon FROM dynamic_menu ORDER BY menu_order');
                    $refs = array();
                    $list = array();
                      
                    while ($data = $hasil->fetch(PDO::FETCH_ASSOC)) {
                        $thisref = &$refs[$data['menu_item_id']];
                        $thisref['menu_parent_id'] = $data['menu_parent_id'];
                        $thisref['menu_item_name'] = $data['menu_item_name'];
                        $thisref['url'] = $data['url'];
                        $thisref['icon'] = $data['icon'];
                        if ($data['menu_parent_id'] == 0) {
                            $list[$data['menu_item_id']] = &$thisref;
                        } else {
                            $refs[$data['menu_parent_id']]['children'][$data['menu_item_id']] = &$thisref;
                        }
                    }

                    function create_list($arr, $urutan) {
                        if ($urutan == 0) {
                            $html = "\n<ul id='sidebar-menu-id' class='sidebar-menu'>\n";
                        } else {
                            $html = "\n<ul id='treeview-menu-id' class='treeview-menu'>\n";
                        }
                        foreach ($arr as $key => $v) {
                            if (array_key_exists('children', $v)) {
                                $html .= "<li class='treeview'>\n";
                                $html .= '<a href="#">
                                            <i class="' . $v['icon'] . '"></i>
                                            <span>' . $v['menu_item_name'] . '</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>';

                                $html .= create_list($v['children'], 1);
                                $html .= "</li>\n";
                            } else {
                                $html .= '<li id="' . $v['url'] . '"><a href="#">';
                                if ($urutan == 0) {
                                    $html .= '<i class="' . $v['icon'] . '"></i>';
                                }
                                if ($urutan == 1) {
                                    $html .= '<i class="fa fa-angle-double-right"></i>';
                                }
                                $html .= $v['menu_item_name'] . "</a></li>\n";
                            }
                        }
                        $html .= "</ul>\n";
                        return $html;
                    }

                    echo create_list($list, 0);
                    ?>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content. loads through ajax -->
            <div id="main-content" class="content-wrapper">


            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                    Anything you want
                </div>
                <!-- Default to the left --> 
                <strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
            </footer>

        </div><!-- ./wrapper -->
    </body>
</html>