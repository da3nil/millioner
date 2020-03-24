    <?php
        $email = $_SESSION['userid'];
        require('php-includes/connect.php');
        
        //Данные из БД
        $i=1;
    	$query = mysqli_query($con,"select * from users where email='$email' order by id desc");
    	if(mysqli_num_rows($query)>0){
    		while($row=mysqli_fetch_array($query)){
    			$date = $row['date'];
    			$id = $row['id'];
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
    background-color: #000;
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
                      background-color:#ab5b5b !important;
                      color:#fff;
                  }
                  .bb_btn:hover {
                      background-color:#fff;
                      color:#000;!important;

                  }
                  .bb_btn a{
                      color:#fff;
                  }
                  .bb_btn a:hover {
                      
                      color:#000;!important;

                  }
                  .bb_btn_close{
                          border: 1px solid #8a4949;
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
                <h3 class="modal_body_txt"> Необходимо активировать аккаунт</h3>
      <p> Просмотри видео и нажми клавишу "Активировать"</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="bb_btn_close btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="bb_btn btn btn-primary"><a href="http://pay.yamillioner.com/">Активировать</a></button>
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

            
          </li>


              <li><a><b style="color:red;"></b> <?php echo $email; ?> <b style="color:white;"></b></a></li>


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
        background-color: #000;
        padding: 15px 10px;
      }

    </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 918px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 >Необходимо активировать аккаунт</h1>
      <p> Просмотри видео и нажми клавишу "Активировать"<b></b></p>

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

                    <a class='bb_btn btn btn-primary' href="http://pay.yamillioner.com/">Активировать</a>
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
              <span class="info-box-number"> - <?php echo $user_pack; ?>
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
              <span class="info-box-number">-<?php echo $user_podkl; ?></span>
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
              <span class="info-box-number">-<?php echo $user_id; ?></span>
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
              <span class="info-box-number">-<?php echo $user_dohod; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->



          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Мониторинг работы системы</h3>

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
                  <tr>
                    <td><?php $dd=date('d');$dm=date('i');$dh=date('h'); echo $dd-1;echo $dh+1+$dh;?></td>
                    <td>RUB</td>
                    <td><span class="label label-success">Investor Base</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">
                      <?php 
                      //data
                      $c=date('d.m.20y'); echo $c; ?>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $dd-1;echo $dh+2+$dh;?></td>
                    <td>RUB</td>
                    <td><span class="label label-success">Investor Base</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f39c12" data-height="20"><?php echo $c; ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $dd-1;echo $dh+4+$dh;?></td>
                    <td>RUB</td>
                    <td><span class="label label-success">Investor Base</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f56954" data-height="20"><?php echo $c; ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $dd-1;echo $dh+9+$dh;?></td>
                    <td>RUB</td>
                    <td><span class="label label-success">Investor Base</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00c0ef" data-height="20"><?php echo $c; ?></div>
                    </td>
                  </tr>


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
    </section>
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
        console.log('work!');
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
