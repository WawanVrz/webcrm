<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <meta http-equiv="refresh" content="5"> --->
  <title>RPCB Syantikara's Management Information Systems</title>
  <base href="<?php echo base_url();?>" />
  <base src="<?php echo base_url();?>" />

  <link rel="shortcut icon" href="assets/dashboard/dist/img/logofix.gif">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="assets/dashboard/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dashboard/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="assets/dashboard/dist/css/skins/_all-skins.min.css">

  <!-- <link rel="stylesheet" href="assets/dashboard/plugins/iCheck/all.css"> -->

  <!-- Date Picker -->
  <link rel="stylesheet" href="assets/dashboard/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="assets/dashboard/plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="assets/dashboard/plugins/datatables/dataTables.bootstrap.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="assets/dashboard/plugins/select2/select2.min.css">
  <!-- This is what you need -->
  <script src="assets/sweatalert/dist/sweetalert.js"></script>
  <link rel="stylesheet" href="assets/sweatalert/dist/sweetalert.css">

  <style>
  .link{display:inline-block;}
  .tooltip1{
      /*Terserah desainnya bagaimana~*/
      background:#303030;
      padding:20px;
      color:#f0f0f0;
      border-radius:10px;
      -moz-border-radius:10px;
      width:200px;
      text-align:center;

      /*yang ini penting!*/
      position:absolute;
  }

  .tooltip1:before{
      /*wajib!*/
      content:"";
      position:absolute;

      /*ini nih cara buat segitiga tanpa gambar dgn CSS*/
      border:10px solid transparent;
      border-bottom:10px solid #303030;

      /*supaya lokasi segitiganya rapi*/
      top:-20px;
      left:10px;
  }

  .tooltip1{display:none;} /*dalam keadaan biasa tidak tampil*/
  .link:hover .tooltip1{display:block;} /*ketika mouse diarahkan ke a.link, tooltip ditampilkan*/

    fieldset.scheduler-border {
      border: 1px groove #ddd !important;
      padding: 0 1.4em 0 1.4em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow:  0px 0px 0px 0px #000;
              box-shadow:  0px 0px 0px 0px #000;
      }

      legend.scheduler-border {
          font-size: 1.2em !important;
          font-weight: bold !important;
          text-align: left !important;
          width:auto;
          padding:0 10px;
          margin-top: 20px;
          border-bottom:none;
      }
  </style>

  <script type="text/javascript" src="assets/dashboard/dist/js/jquery-latest.js"></script>
  <script type="text/javascript">
  function getpesan() {
    $.get('<?php echo base_url(). 'api/pesan/all'; ?>', function(response) {
        var datapesan = JSON.parse(response);
        var jm1 = datapesan.length;
        var jm2 = datapesan.length;
        document.getElementById("jmpesan1").innerHTML=jm1;
        document.getElementById("jmpesan2").innerHTML=jm2;
    jQuery.each( datapesan, function( key, value ){
          $("#kotakpesan").append("<tr><td width='5%'><img src='assets/dashboard/dist/img/nopp.jpg' width='50' height='50' class='img-circle' alt='User Image'></td><td width='48%'><p align='left' style='font-size:13px;'><a href='dashboard/admin/data/pesan/detail/"+value.id_pesan+"'>"+value.fullname+"</a></p><p align='left' style='margin-top:-10px; font-size:11px; color:#9e9e9e;'>"+value.subject+"</p></td><td ><small>"+value.created_at+"</small></td></tr>");
        });
    });

    $.get('<?php echo base_url(). 'api/transaksi/reservasi/all'; ?>', function(response) {
        var datareserv = JSON.parse(response);
        var jm3 = datareserv.length;
        var jm4 = datareserv.length;
        document.getElementById("jmpesan3").innerHTML=jm3;
        document.getElementById("jmpesan4").innerHTML=jm4;
        //console.log(datapesan);
    jQuery.each( datareserv, function( key, value ){
          $("#kotakreservasi").append("<tr><td width='5%'><img src='assets/dashboard/dist/img/"+value.image+"' width='50' height='50' class='img-circle' alt='User Image'></td><td width='48%'><p align='left' style='font-size:13px;'><a href='dashboard/admin/data/reservasi/detail/"+value.id_transaksi+"'>Instansi : "+value.instansi+"</a></p><p align='left' style='margin-top:-10px; font-size:11px; color:#9e9e9e;'>Pemesan : "+value.nama_pemesan+"<br>Check In : "+value.tgl_checkin+"</p></td><td ><small>"+value.created_at+"</small></td></tr>");
        });
    });
  }
  </script>

</head>
<body class="hold-transition skin-blue sidebar-mini" onload="getpesan()">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>R</b>SY</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>RPCB </b>Syantikara</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php
            $in = $this->session->userdata("type");
            if($in == 'Super Admin')
            {
          ?>
          <li class="dropdown messages-menu">
            <a href="<?php echo base_url('/'); ?>" target="_blank" title="Go To Web Public">
              <i class="fa fa-globe"></i>
            </a>
          </li>

          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <?php
                $sql ="SELECT * FROM pesan where status = 'unread'";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0)
                {
               ?>
                    <span class="label label-success"><span id="jmpesan1"></span></span>
                <?php
                  }else {

                  }
              ?>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <span id="jmpesan2"></span> messages</li>
              <li>
                <ul class="menu">
                  <li>
                    <ul class="menu">
                      <!-- <div id="kotakpesan"></div> -->
                        <table class='table' id="kotakpesan">

                        </table>
                      </ul>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url('dashboard/admin/data/pesan'); ?>">See All Messages</a></li>
            </ul>
          </li>

          <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <?php
                  $sql ="SELECT * FROM transaksi where isread = 0";
                  $query = $this->db->query($sql);
                  if ($query->num_rows() > 0)
                  {
                 ?>
                      <span class="label label-danger"><span id="jmpesan3"></span></span>
                <?php
                  }else {

                  }
                ?>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have <span id="jmpesan4"></span> notifications</li>
                <li>
                  <ul class="menu">
                    <table class='table' id="kotakreservasi">

                    </table>
                  </ul>
                </li>
                <li class="footer"><a href="<?php echo base_url('dashboard/admin/data/reservasi'); ?>">View all</a></li>
              </ul>
            </li>
          <?php
            }else {

            }
           ?>


          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="assets/dashboard/dist/img/<?php echo $this->session->userdata("gambar"); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin <?php echo $this->session->userdata("fullname"); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="assets/dashboard/dist/img/<?php echo $this->session->userdata("gambar"); ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata("fullname"); ?>
                  <small>Member since &nbsp; <?php echo $this->session->userdata("membersince"); ?></small>
                </p>
              </li>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('dashboard/admin/profile'); ?>" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-user"> Profile </i></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('panel/auth/logout'); ?>" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-log-out"> Logout </i></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="assets/dashboard/dist/img/<?php echo $this->session->userdata("gambar"); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin <?php echo $this->session->userdata("fullname"); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- Menu Nav-->
        <?php include "MenuNav.php"; ?>
      <!----------->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
    </section>

<!--------------CONTENT------------------>
