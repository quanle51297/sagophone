<!DOCTYPE html>
<html lang="en" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Apex admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Apex admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">

    <title>Login Page - Sagophone</title>
    <base href="{{ asset('') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="admin_asset/app-assets/img/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="admin_asset/app-assets/img/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="admin_asset/app-assets/img/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="admin_asset/app-assets/img/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="admin_asset/app-assets/img/ico/sago.ico">
    <link rel="shortcut icon" type="image/png" href="admin_asset/app-assets/img/ico/sago-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="admin_asset/app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="admin_asset/app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="admin_asset/app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="admin_asset/app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="admin_asset/app-assets/vendors/css/prism.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="admin_asset/app-assets/css/app.css">
    <!-- END APEX CSS-->
    <!-- BEGIN Page Level CSS-->
    <!-- END Page Level CSS-->
  </head>
  <body data-col="1-column" class=" 1-column  blank-page blank-page">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper nav-collapsed menu-collapsed">
      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Login Page Starts-->
<section id="login">
    <div class="container-fluid">
        <div class="row full-height-vh">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="card gradient-indigo-purple text-center width-400">
                    <div class="card-img overlap">
                        <img alt="element 06" class="mb-1" src="admin_asset/app-assets/img/portrait/avatars/avatar-08.png" width="190">
                    </div>
                    <div class="card-body">
                        <div class="card-block">
                            <h2 class="white">Đăng nhập</h2>
                            @if(count($errors)>0)
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $err)
                                        {{ $err }}<br>
                                    @endforeach
                                </div>
                            @endif

                            @if(session('thongbao'))
                                <div class="alert alert-danger">
                                    {{ session('thongbao') }}
                                </div>
                            @endif
                            <form action="admin/dangnhap" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="txtUsername"  placeholder="Tài khoản username" required >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="txtPassword" placeholder="Mật khẩu" required>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0 ml-3">
                                                <input type="checkbox" class="custom-control-input" checked id="rememberme">
                                                <label class="custom-control-label float-left white" for="rememberme">Remember Me</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-pink btn-block btn-raised">Đăng nhập</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="card-footer">
                        <div class="float-left"><a (click)="onForgotPassword()" class="white">Recover Password</a></div>
                        
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--Login Page Ends-->
          </div>
        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="admin_asset/app-assets/vendors/js/core/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/vendors/js/core/popper.min.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/vendors/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/vendors/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/vendors/js/prism.min.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/vendors/js/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/vendors/js/screenfull.min.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/vendors/js/pace/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN APEX JS-->
    <script src="admin_asset/app-assets/js/app-sidebar.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/js/notification-sidebar.js" type="text/javascript"></script>
    <script src="admin_asset/app-assets/js/customizer.js" type="text/javascript"></script>
    <!-- END APEX JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- END PAGE LEVEL JS-->
  </body>
</html>