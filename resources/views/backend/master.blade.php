<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('backend/template/dist/css/AdminLTE.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('backend/template/dist/css/skins/_all-skins.min.css') }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	    <link rel="shortcut icon" href="{{{ asset('frontend/images/favion.png') }}}">
        <!-- Google Font -->
        <link rel="stylesheet" href="{{ asset('backend/css/jquery.toastmessage.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ajsr-confirm.css') }}">
        <link rel="stylesheet" href="{{ asset('general/css/combobox.css') }}">
        <link rel="stylesheet" href="{{ asset('/general/css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
        <!-- jQuery 3 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- <script src="{{ asset('backend/template/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.easing.min.js') }}"></script -->
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('backend/template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/js/script-top.js') }}"></script>
        <script src="{{ asset('backend/js/moment.min.js') }}"></script>
        <script src="{{ asset('backend/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('general/js/combobox.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <link rel="stylesheet" href="{{ asset('backend/template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">
        <script>
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
        </script>
        <script src="{{ asset('general/js/function.js') }}"></script>
        <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="{{ url('/admincp') }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>TB</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Barcodelive</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <?php
                        // echo $cmm_lang;die;
                    ?>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ asset('backend/template/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ asset('backend/template/dist/img/user2-160x160.jpg') }}" class="img-minus" alt="User Image">
                                        <p>
                                            {{ Auth::user()->name }}
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        {{-- <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div> --}}
                                        <div class="pull-right">
                                            <a href="{{ route('logout-admin') }}" class="btn btn-default btn-flat">Thoát</a>
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
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ asset('backend/template/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{ Auth::user()->name }}</p>
                                <i class="fa fa-circle text-success"></i> Đang hoạt động
                        </div>
                    </div>
                    <!-- search form -->
                    {{-- <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                            </span>
                        </div>
                    </form> --}}
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                    {{--<li class="@if ( Request::is('admincp') ) active @endif">
                            <a href="{{ url('/admincp') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>--}}
                        <li class="treeview @if ( Request::is('admincp/config/editInfo*') || Request::is('admincp/config/slide*') || Request::is('admincp/partners*') || Request::is('admincp/config/menu*') || Request::is('admincp/config/location*')) active @endif">
                            <a href="#">
                                <i class="fa fa-wrench"></i>
                                <span>Cấu hình</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">

                                <li class="@if ( Request::is('admincp/config/editInfo*') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/config/editInfo"><i class="fa fa-minus"></i> Giao diện</a>
                                </li>

                                {{--<li class="@if ( Request::is('admincp/config/slide*') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/config/slide"><i class="fa fa-minus"></i> Slide</a>
                                </li>--}}
                                <li class="@if ( Request::is('admincp/config/menu*') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/config/menu"> <i class="fa fa-minus"></i> Menu</a>
                                </li>
                                <li class="@if ( Request::is('admincp/config/ads*') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/config/ads"> <i class="fa fa-minus"></i> Ads</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview @if ( Request::is('admincp/articles*') || Request::is('admincp/articlecategories*') || Request::is('admincp/articletags*') ) active @endif">
                            <a href="#">
                                <i class="fa fa-newspaper-o"></i>
                                <span>Bài viết</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="@if ( Request::is('admincp/articles') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/articles"><i class="fa fa-minus"></i> Tất cả bài viết</a>
                                </li>
                                <li class="@if ( Request::is('admincp/articles/create') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/articles/create"><i class="fa fa-minus"></i> Bài viết mới</a>
                                </li>
                                <li class="@if ( Request::is('admincp/articlecategories*') ) active @endif">
                                    <a href="{{ url('/') }}/admincp/articlecategories"><i class="fa fa-minus"></i> Danh mục</a>
                                </li>
                            </ul>
                        </li>
                        <li class="@if ( Request::is('admincp/barcodes*') ) active @endif">
                            <a href="{{ url('/') }}/admincp/barcodes">
                                <i class="fa fa-newspaper-o"></i> <span> Barcodes</span>
                            </a>
                        </li>
                        <li class="@if ( Request::is('admincp/pages*') ) active @endif">
                            <a href="{{ url('/') }}/admincp/pages">
                                <i class="fa fa-file"></i> <span> Pages</span>
                            </a>
                        </li>
                        <li class="@if ( Request::is('admincp/affs*') ) active @endif">
                            <a href="{{ url('/') }}/admincp/affs">
                                <i class="fa fa-file"></i> <span> Affiliate</span>
                            </a>
                        </li>

                        <li class="@if ( Request::is('admincp/redirects*') ) active @endif">
                            <a href="{{ url('/') }}/admincp/redirects">
                                <i class="fa fa-space-shuttle" aria-hidden="true"></i>
                               <span>Redirect 301</span>
                            </a>
                         </li>
                        <!-- <li class="@if ( Request::is('admincp/contacts*') ) active @endif">
                            <a href="{{ url('/') }}/admincp/contacts">
                                <i class="fa fa-address-book"></i> <span>Liên hệ</span>
                            </a>
                        </li> -->

                         <!-- <li class="@if ( Request::is('admincp/feedbacks*') ) active @endif">
                            <a href="{{ url('/') }}/admincp/feedbacks">
                                <i class="fa fa-comment" aria-hidden="true"></i>
                               <span>Feedback</span>
                            </a>
                         </li> -->
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.4.0
                </div>
                <strong>Copyright &copy; 2019.</strong> All rights reserved.
            </footer>

            <div class="control-sidebar-bg"></div>
        </div>
        <div class="ajax_waiting"></div>

        <script src="{{ asset('backend/template/bower_components/fastclick/lib/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/template/dist/js/adminlte.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('backend/template/dist/js/demo.js') }}"></script>
        <script src="{{ asset('backend/js/ajsr-jq-confirm.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.toastmessage.js') }}"></script>
        <script src="{{ asset('backend/js/script-bottom.js') }}"></script>
        <script>
            var baseURL="<?php echo URL::to('/'); ?>";
        </script>
    </body>
</html>
