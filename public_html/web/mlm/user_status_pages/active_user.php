<?php

    // $connects = 0;
    $email = $_SESSION['userid'];
    $account = 0;
    require('php-includes/connect.php');
    
    //Данные из БД
    $i=1;
	$query = mysqli_query($con,"select * from users where email='$email' order by id desc");
	if(mysqli_num_rows($query)>0){
		while($row=mysqli_fetch_array($query)){
			$date = $row['date'];
			$date_active = $row['date_active'];
			$id = $row['id'];
			$account = $row['account'];
			$i++;
		}
	}
	// id
	$user_id = $id;

    if ($account == 1){
        $user_pack = "Investor Base";
    } elseif ($account == 2) {
        $user_pack = "Premium";
    } elseif ($account == 3) {
        $user_pack = "Major";
    }


    // дней с момента АКТИВАЦИИ (НЕ с даты РЕГИСТРАЦИИ)
	$diference = strtotime(date('y-m-d')) - strtotime($date_active);
    $days = $diference / 86400;


    // Количество подключений
    // Максимум 10 для INVESTOR, дальше счетчик не растет (не будет больше 243 подключений)

    //Investor BASE
    if ($account == 1) {
        if ($days >= 10){
            $user_podkl = 243;
        } else {
            $user_podkl = $days * 24;
        }

        //Premium
    } elseif ($account == 2) {
        if ($days >=450){
            $user_podkl = 10800;
        } else {
            $user_podkl = $days * 24;
        }

        // Major
    } elseif ($account == 3) {
        if ($days >= 3847) {
            $user_podkl = 92340;
        } else {
            $user_podkl = $days * 24;
        }
    }

    
    // доход
    $user_dohod = $user_podkl * 200; //Если 243 подкл = 48600, то 1 = 200


    /* Мониторинг работы
     * Скрипт получает последние 4 записи c АКТИВИРОВАННЫМИ АККАУНТАМИ из БД
     * Наиболее оптимизированная версия
     */

    $monitor_info = [];
    $i = 1;
    $query = mysqli_query($con, "
    (SELECT * FROM users WHERE account>0 ORDER BY id DESC LIMIT 4)
    UNION
    (SELECT * FROM users WHERE account>0 ORDER BY id DESC LIMIT 4)
    UNION
    (SELECT * FROM users WHERE account>0 ORDER BY id DESC LIMIT 4)
    ");
    if(mysqli_num_rows($query)>0){
        while($row=mysqli_fetch_array($query)){
            array_push($monitor_info, [$row['id'],'RUB', $row['account'], $row['date_active']]);
            $i++;
        }
    }

    // дерево
    $tree = array(
            1 => array(),
            2 => array(),
            3 => array(),
            4 => array(),
            5 => array()
    );

    $i=1;
    $query = mysqli_query($con,"select * from tree where user_id='$user_id'");
    if(mysqli_num_rows($query)>0){
        while($row=mysqli_fetch_array($query)){
            $tree[1] = explode(',',$row['lvl1']);
            $tree[2] = explode(',',$row['lvl2']);
            $tree[3] = explode(',',$row['lvl3']);
            $tree[4] = explode(',',$row['lvl4']);
            $tree[5] = explode(',',$row['lvl5']);
            $i++;
        }
    }

?>
  
<body class="hold-transition skin-blue sidebar-mini">

    <style>
    body {
        padding-right: 0 !important;
    }
    .sidebar-collapse .menu_span_d3 {
    	display: none;
    }

    @media screen and (max-width: 600px) {
    .main-footer{
        height:50px;
    }
        .packet__info a {
    display: block;
    margin-top: 1px;
    text-decoration: none;
    color: #fff;
    background-color: #bfbfbf;
    padding: 15px 10px;
}
    }
        .wrapper {position: static !important;}
html {background-color: #ECF0F5 !important;}
.fa{

    padding-right: 15px;

}
.main_header{
    background-color:#000 !important;
}

                  .bb_btn{
                      background-color:#000 !important;
                  }
                  .bb_btn:hover {
                      background-color:#fff;
                      color:#000;

                  }

    </style>
<div class="wrapper" >
    <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <!--<div class="modal-header">-->
              <!--  <h5 class="modal-title" id="exampleModalLabel">Ошибка!</h5>-->
              <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
              <!--    <span aria-hidden="true">&times;</span>-->
              <!--  </button>-->
              <!--</div>-->

              <div class="modal-body">
                <h3 class="modal_body_txt">Будет доступно после запуска платформы</h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <!--<button type="button" class="bb_btn btn btn-primary"><a href="http://pay.yamillioner.com/">Активировать</a></button>-->
              </div>
            </div>
          </div>
        </div>

        <!-- Modal tree -->
        <div class="modal fade" id="exampleModalTree" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!--<div class="modal-header">-->
                    <!--  <h5 class="modal-title" id="exampleModalLabel">Ошибка!</h5>-->
                    <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                    <!--    <span aria-hidden="true">&times;</span>-->
                    <!--  </button>-->
                    <!--</div>-->

                    <div class="modal-header"><h4>Дерево</h4></div>
                    <div class="modal-body">
                        <div align="center"><?php echo $email?></div>
                        <script>
                            $(function(){
                                $("#myTab a").click(function(e){
                                    e.preventDefault();
                                    $(this).tab('show');
                                });
                            });
                        </script>
                        <ul id="myTab" class="nav nav-tabs" style="margin-top: 20px">
                            <li class="active"><a href="#panel1">Уровень 1</a></li>
                            <li><a href="#panel2">Уровень 2</a></li>
                            <li><a href="#panel3">Уровень 3</a></li>
                            <li><a href="#panel4">Уровень 4</a></li>
                            <li><a href="#panel5">Уровень 5</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="panel1" class="tab-pane fade in active">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Пользователь</th>
                                        <th>Информация</th>
                                        <th>Информация</th>
                                    </tr>
                                    <?php
                                        foreach($tree[1] as $item_tree):
                                    ?>
                                    <tr>
                                        <td><?php echo $item_tree ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <div id="panel2" class="tab-pane fade">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Пользователь</th>
                                        <th>Информация</th>
                                        <th>Информация</th>
                                    </tr>
                                    <?php
                                        foreach($tree[2] as $item_tree):
                                    ?>
                                    <tr>
                                        <td><?php echo $item_tree ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <div id="panel3" class="tab-pane fade">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Пользователь</th>
                                        <th>Информация</th>
                                        <th>Информация</th>
                                    </tr>
                                    <?php
                                        foreach($tree[3] as $item_tree):
                                    ?>
                                    <tr>
                                        <td><?php echo $item_tree ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <div id="panel4" class="tab-pane fade">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Пользователь</th>
                                        <th>Информация</th>
                                        <th>Информация</th>
                                    </tr>
                                    <?php
                                        foreach($tree[4] as $item_tree):
                                    ?>
                                    <tr>
                                        <td><?php echo $item_tree ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <div id="panel5" class="tab-pane fade">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Пользователь</th>
                                        <th>Информация</th>
                                        <th>Информация</th>
                                    </tr>
                                    <?php
                                        foreach($tree[5] as $item_tree):
                                    ?>
                                    <tr>
                                        <td><?php echo $item_tree ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>

                        <h3 class="modal_body_txt"></h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <!--<button type="button" class="bb_btn btn btn-primary"><a href="http://pay.yamillioner.com/">Активировать</a></button>-->
                    </div>
                </div>
            </div>
        </div>

    <style>
        @media (max-width: 518px) {
            .ref__btn {
                margin-left: 0 !important;
            }
        }
        
       @media (max-width: 497px) {
           .ref__btn {
               margin-left: 0 !important;
               margin-top: 10px;
           }
       } 
    </style>
        <!-- Modal referal -->
        <div class="modal fade" id="exampleModalRef" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!--<div class="modal-header">-->
                    <!--  <h5 class="modal-title" id="exampleModalLabel">Ошибка!</h5>-->
                    <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                    <!--    <span aria-hidden="true">&times;</span>-->
                    <!--  </button>-->
                    <!--</div>-->
                    <div class="modal-header"><h4>Добавить участника</h4></div>
                    <div class="modal-body">
                        <form action="handler.php" method="post">
                            <input class="input-lg pull-left" type="email" name="email" placeholder="Email агента"">
                            <button class="ref__btn btn-group btn btn-lg pull-left" type="submit" style="margin-left: 20px">Отправить письмо</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
<!--                    --><?php
//                    if( isset($_POST['emailref']) ) {
//                        require_once __DIR__ . 'mailer/Validator.php';
//                        require_once __DIR__ . 'mailer/ContactMailer.php';
//
//                        if (!Validator::isAjax() || !Validator::isPost()) {
//                            echo 'Доступ запрещен!';
//                            exit;
//                        }
//
////$name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : null;
//                        $emailx = isset($_POST['emailref']) ? trim(strip_tags($_POST['email'])) : null;
////$phone = isset($_POST['phone']) ? trim(strip_tags($_POST['phone'])) : null;
////$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : null;
//
//                        if (empty($emailx)) {
//                            echo 'Необходимо заполнить поле Email';
//                            exit;
//                        }
//
//                        if (!Validator::isValidEmail($emailx)) {
//                            echo 'E-mail не соответствует формату.';
//                            exit;
//                        }
//
//                        if (ContactMailer::sendRef($emailx)) {
//                            echo "Успешно";
//                        } else {
//                            echo 'Произошла ошибка! Не удалось отправить приглашение';
//                        }
//
//                        exit;
//                    }
//                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <!--<button type="button" class="bb_btn btn btn-primary"><a href="http://pay.yamillioner.com/">Активировать</a></button>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h3>Вывод произведен</h3>
              </div>
              <div class="modal-footer">
                <!--<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#exampleModal3"><a href="http://pay.yamillioner.com/take.php">Вывести средства</a></button>-->
                <button type="button" class="bb_btn btn btn-primary" data-dismiss="modal">Закрыть</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h5>Средства поступят на указанный Payeer-кошелёк в ближайшее время</h5>
              </div>
              <div class="modal-footer">

                <button type="button" class="bb_btn btn btn-primary" data-dismiss="modal">Закрыть</button>
              </div>
            </div>
          </div>
        </div>
  <header class="main-header">
<style>
    .logo{
        background-color:#fff !important;
    }
    .logo-lg{
        color:#000;
    }
</style>
    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style='color: #000 !important;'><b>Я</b>М</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Я</b>МИЛЛИОНЕР</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" id='d3_toggle' class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">

            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">

            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          

            <li><a><?php echo $email; ?> </a></li>
            <li><a href="logout">Выйти</a></li>


        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">

       <style>
        .modal-backdrop {
          z-index: 0;
        }

        .modal-dialog {
          margin-top: 60px;
        }

        .da3nil__menu li > button {
          line-height: 35px;
          background-color: unset;
          width: 100%;
          border: none;
          color: #b8c7ce;
          text-align: left;
          padding-left: 18px;
        }

        .da3nil__menu li:hover {
          background-color: #1E282C;
          color: white;

        }

        .da3nil__menu li > button:hover {
            color: white;
        }

        .da3nil__menu li > button > span {
          padding-left: 10px;
        }
        .thumb-wrap {
          position: relative;
          padding-bottom: 56.25%; /* задаёт высоту контейнера для 16:9 (если 4:3 — поставьте 75%) */
          padding-top: 30px;
          height: 0;
          overflow: hidden;
        }
        .thumb-wrap iframe {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
        }

      </style>

      <!-- Sidebar user panel -->

      <!-- search form -->

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree da3nil__menu" data-widget="tree" data-toggle="toggle" >
        <li class="header">Навигация</li>
        <!--<li class="active treeview menu-open">-->


      
        <style>

            .bb{
                padding-left:5px;
                padding-right:18px;
            }
            .bb_static{
                padding-right:14px  ;
            }
            .bb_up{
                padding-right:16px;
            padding-left:2px;
            }
        </style>

        <li>
          <button type="button" >
            <i class="fa fa-laptop"></i> <span class='menu_span_d3'>Личный кабинет</span>
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-gears"></i> <span class='menu_span_d3'>Техническая поддержка</span>
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModal">
            <i class="bb fas fa-dollar-sign"></i> <span class='menu_span_d3'>Вывод средств</span>
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModal">
            <i class="bb_static fas fa-money-check-alt"></i> <span class='menu_span_d3'>Статистика</span>
          </button>
        </li>
        <li>
          <button type="button" data-toggle="modal" data-target="#exampleModal">
            <i class="bb_up far fa-arrow-alt-circle-up"></i> <span class='menu_span_d3'>Апгрейд</span>
          </button>
        </li>
          <li>
              <button type="button" data-toggle="modal" data-target="#exampleModalRef">
                  <i class="bb_up fas fa-plus-circle"></i> <span class='menu_span_d3'>Добавить участника</span>
              </button>
          </li>
          <li>
              <button type="button" data-toggle="modal" data-target="#exampleModalTree">
                  <i class="bb_up fas fa-street-view"></i> <span class='menu_span_d3'>Дерево</span>
              </button>
          </li>










      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


    <style>
    .box.box-info{
        border-top-color:#000;
    }
      .packet {
        /*margin: 20px 0 20px;*/
        border-top-color:#000 !important;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        /*position: relative;*/
        /*background-color: red;*/
      }
      .packet__text {
        /*position: absolute;*/
        text-align: center;

        /*padding: 5px 0;
        margin: 0;*/
        /*top: 50%;*/
        /*bottom: 50%;*/
      }

      .packet__info h2 {
        text-align: center;
        line-height: 30px;
        font-size: 30px;
        padding: 5px 0;
        margin: 0;
      }

      .packet__info a {
        display: block;
        margin-top: 15px;
        text-decoration: none;
        color: #fff;
        background-color: #bfbfbf;
        padding: 15px 10px;
      }

    </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 918px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 >Аккаунт активирован</h1>
      <p>Вывод средств будет доступен при достаточном количестве подключений <b></b></p>

    </section>

    <!-- Main content -->
    <section class="content">

        <div>
            <div class="row" style="display: flex; align-items: stretch; margin-bottom: 20px;flex-wrap: wrap;">
              <div class="col-md-6 col-xs-12" style='padding: 15px'>
                  <div class="packet box" style="padding: 10px;border-top-color: #2c6399;">
                  <div class="packet__info" style="width: 100%;">
                    <div class="thumb-wrap">
                          <iframe width="578" height="292" src="https://www.youtube.com/embed/FA5gNvUKoQQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>

              </div>

            <div class="col-md-6 col-xs-12" style='padding: 15px'>
                <div class="packet box" style="border-top-color: #2c6399;">
                  <div class="packet__info">
                    <h5>Доступный инвестиционный пакет</h5>
                    <h2>BASE</h2>
                    <hr>
                    <style>
                        .bb_btn1{
                        background-color:#b1b1b1 !important
                        }
                    </style>
                    <a class='bb_btn_active btn btn-primary' >Активировано</a>
                    <!--<a class='bb_btn btn btn-primary' href="http://pay.yamillioner.com/">Активировано</a>-->
                  </div>
                </div>
            </div>
          </div>
      </div>

      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><img src="https://img.icons8.com/ios/48/000000/coins.png"></span>

            <div class="info-box-content">
              <span class="info-box-text">Ваш портфель</span>
              <span class="info-box-number"><?php echo $user_pack; ?>
        </span>
            </div>

            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><img src="https://img.icons8.com/ios/48/000000/network.png"></span>

            <div class="info-box-content">
              <span class="info-box-text">Подключения</span>
              <span class="info-box-number">
                  <?php
                    echo $user_podkl;
                  ?>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">
              <img src="https://img.icons8.com/ios/48/000000/employee-card.png">
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Ваш ID</span>
              <span class="info-box-number">
              <?php 
              
              echo $user_id;
              ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><img src="https://img.icons8.com/ios/48/000000/positive-dynamic.png"></span>

            <div class="info-box-content">
              <span class="info-box-text">Ваш доход</span>
              <span class="info-box-number">
                  <?php
                  echo $user_dohod;
                  ?>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!--<div class="row">-->
      <!--  <div class="col-md-12">-->
      <!--    <div class="box">-->
      <!--      <div class="box-header with-border">-->
      <!--        <h3 class="box-title">Статистика дохода клуба</h3>-->


      <!--      </div>-->
            <!-- /.box-header -->

            <!-- ./box-body -->
      <!--      <div class="box-footer">-->
      <!--        <div class="row">-->
      <!--          <div class="col-sm-3 col-xs-6">-->
      <!--            <div class="description-block border-right">-->
      <!--              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
      <!--              <h5 class="description-header">$35,210.43</h5>-->
      <!--              <span class="description-text">Доход компании</span>-->
      <!--            </div>-->
                  <!-- /.description-block -->
      <!--          </div>-->
                <!-- /.col -->
      <!--          <div class="col-sm-3 col-xs-6">-->
      <!--            <div class="description-block border-right">-->
      <!--              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 10%</span>-->
      <!--              <h5 class="description-header">$10,390.90</h5>-->
      <!--              <span class="description-text">Выплаты участникам</span>-->
      <!--            </div>-->
                  <!-- /.description-block -->
      <!--          </div>-->
                <!-- /.col -->
      <!--          <div class="col-sm-3 col-xs-6">-->
      <!--            <div class="description-block border-right">-->
      <!--              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
      <!--              <h5 class="description-header">$24,813.53</h5>-->
      <!--              <span class="description-text">Доход за неделю</span>-->
      <!--            </div>-->
                  <!-- /.description-block -->
      <!--          </div>-->
                <!-- /.col -->
      <!--          <div class="col-sm-3 col-xs-6">-->
      <!--            <div class="description-block">-->
      <!--              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 100%</span>-->
      <!--              <h5 class="description-header">93700</h5>-->
      <!--              <span class="description-text">Совершено выплат</span>-->
      <!--            </div>-->
                  <!-- /.description-block -->
      <!--          </div>-->
      <!--        </div>-->
              <!-- /.row -->
      <!--      </div>-->
            <!-- /.box-footer -->
      <!--    </div>-->
          <!-- /.box -->
      <!--  </div>-->
        <!-- /.col -->
      <!--</div>-->
      <!-- /.row -->

      <!-- Main row -->
      <!--<div class="row">-->
        <!-- Left col -->
      <!--  <div class="col-md-8">-->
          <!-- MAP & BOX PANE -->

          <!-- /.box -->
      <!--    <div class="row">-->
      <!--      <div class="col-md-6">-->
              <!-- DIRECT CHAT -->

              <!--/.direct-chat -->
      <!--      </div>-->
            <!-- /.col -->


            <!-- /.col -->
      <!--    </div>-->
          <!-- /.row -->


          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Мониторинг работы системы</h3>
                <?php
                //var_dump($monitor_info);
                ?>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>ID участника</th>
                    <th>Валюта</th>
                    <th>Портфель</th>
                    <th>Дата активации</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php

                  foreach ($monitor_info as $persona):
                  ?>
                  <tr>
                      <td><?php echo $persona[0]?></td>
                      <td><?php echo $persona[1]?></td>
                      <td>
                          <span class="label label-success">
                              <?php
                              if ($persona[2] == 1){
                                  echo "Investor Base";
                              } elseif ($persona[2] == 2) {
                                  echo "Premium";
                              } elseif ($persona[2] == 3) {
                                  echo "Major";
                              }
                              ?>
                          </span>
                      </td>
                      <td><div class="sparkbar" data-color="#f39c12" data-height="20"><?php echo $persona[3]?></div></td>
                  </tr>
                  <?php endforeach;?>



<!--                  <tr>-->
<!--<!--                    <td><?php ////$dd=date('d');$dm=date('i');$dh=date('h'); echo $dd-1;echo $dh+1+$dh;?><!--<!--</td>
<!--                      <td>--><?php //echo $monitor_info[0][0]?><!--</td>-->
<!--                      <td>--><?php //echo $monitor_info[0][1]?><!--</td>-->
<!--                    <td>-->
<!--                        <span class="label label-success">-->
<!--                            --><?php
//                            if ($monitor_info[0][2] == 1){
//                                echo "Investor Base";
//                            } elseif ($monitor_info[0][2] == 2) {
//                                echo "Premium";
//                            } elseif ($monitor_info[0][2] == 3) {
//                                echo "Major";
//                            }
//                            ?>
<!--                        </span>-->
<!--                    </td>-->
<!--                    <td>-->
<!--                      <div class="sparkbar" data-color="#00a65a" data-height="20">-->
<!--                      --><?php //
//                      //data
//                      //$c=date('d.m.20y'); echo $c;
//                      echo $monitor_info[0][3];
//                      ?>
<!--                      </div>-->
<!--                    </td>-->
<!--                  </tr>-->
<!--                  <tr>-->
<!--                    <td>--><?php //echo $dd-1;echo $dh+2+$dh;?><!--</td>-->
<!--                    <td>RUB</td>-->
<!--                    <td>-->
<!--                        <span class="label label-success">-->
<!--                            Investor Base-->
<!---->
<!--                        </span>-->
<!--                    </td>-->
<!--                    <td>-->
<!--                      <div class="sparkbar" data-color="#f39c12" data-height="20">--><?php //echo $c; ?><!--</div>-->
<!--                    </td>-->
<!--                  </tr>-->
<!--                  <tr>-->
<!--                    <td>--><?php //echo $dd-1;echo $dh+6+$dh;?><!--</td>-->
<!--                    <td>RUB</td>-->
<!--                    <td><span class="label label-success">Investor Base</span></td>-->
<!--                    <td>-->
<!--                      <div class="sparkbar" data-color="#f56954" data-height="20">--><?php //echo $c; ?><!--</div>-->
<!--                    </td>-->
<!--                  </tr>-->
<!--                  <tr>-->
<!--                    <td>--><?php //echo $dd-1;echo $dh+9+$dh;?><!--</td>-->
<!--                    <td>RUB</td>-->
<!--                    <td><span class="label label-success">Investor Base</span></td>-->
<!--                    <td>-->
<!--                      <div class="sparkbar" data-color="#00c0ef" data-height="20">--><?php //echo $c; ?><!--</div>-->
<!--                    </td>-->
<!--                  </tr>-->


                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

              <!--<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">Обновить</a>-->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->
    </body>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<style>
    .footer_span{
        color:#000;
    }
</style>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">

    </div>
    <strong> © 2018-2019. <span class="footer_span">ЯМИЛЛИОНЕР</span></strong>
  </footer>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--<script src="static/bower_components/jquery/dist/jquery.min.js"></script>-->
<!-- Bootstrap 3.3.7 -->
<script src="/web/mlm/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/web/mlm/static/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/web/mlm/static/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="/web/mlm/static/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="/web/mlm/static/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/web/mlm/static/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="/web/mlm/static/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="/web/mlm/static/bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/web/mlm/static/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/web/mlm/static/dist/js/demo.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
        console.log('');
        function D3showText(){
            $('#d3_toggle').bootstrapToggle('on');
        }

        // function bootstrapToggle('off') {
        //     var el = $(".da3nil__menu button>span");
        //     console.log(el);
        //     el.css("display","none");
        // }

        // function bootstrapToggle('on') {
        //     var el = $(".da3nil__menu button>span");
        //     console.log(el);
        //     el.css("display","none");
        // }

        // $('#d3_toggle').bootstrapToggle('off')(function(){
        //     var el = $(".da3nil__menu button>span");
        //     console.log(el);
        //     el.css("display","inline");
        // });

        $('#d3_toggle').click(function(){
            // if ($('#d3_toggle').bootstrapToggle('on')) {
            //     console.log(1)
            // }
            // else {
            //     console.log(2)
            // }
            console.log(bootstrapToggle);
        });
</script>
