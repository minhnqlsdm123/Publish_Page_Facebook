<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('backend/images/favicon.ico')}}" type="image/ico" />
    <title>Trang quản trị</title>

    <!-- Bootstrap -->
    <link href="{{ asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('backend/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('backend/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}"
        rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('backend/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('backend/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <link href="{{ asset('backend/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Dropzone.js -->
    <link href="{{ asset('backend/vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/build/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/build/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
    <style>
        @yield('css')
    </style>
    <!-- Custom Theme Style -->
    <link href="{{ asset('backend/build/css/custom.min.css') }}" rel="stylesheet">
    @if(session('toastr'))
    <script>
        var TYPE_MESSAGE = "{{session('toastr.type')}}";
        var MESSAGE      = "{{session('toastr.message')}}";
    </script>
    @endif
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella
                                Alela!</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ asset('backend/images/img.jpg') }}" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            @if (Auth::check())
                            <h2>{{ Auth::user()->name }}</h2>
                            @endif

                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    @include("backend.component.sidebar");
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout"
                            href="{{ route('admin.user.logout') }}">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ asset('backend/images/img.jpg') }}" alt="">
                                    @if (Auth::check())
                                    {{ Auth::user()->email }}
                                    @endif
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="javascript:;"> Profile</a></li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="badge bg-red pull-right">50%</span>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li><a href="javascript:;">Help</a></li>
                                    <li><a href="{{ route('admin.user.logout') }}"><i
                                                class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>

                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ asset('backend/images/img.jpg') }}"
                                                    alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ asset('backend/images/img.jpg') }}"
                                                    alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ asset('backend/images/img.jpg') }}" alt="
                                                    Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="{{ asset('backend/images/img.jpg') }}"
                                                    alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
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
            @yield('content')
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('backend/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('backend/vendors/fastclick/lib/fastclick.j') }}s"></script>
    <!-- NProgress -->
    <script src="{{ asset('backend/vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('backend/vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('backend/vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('backend/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('backend/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('backend/vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('backend/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('backend/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('backend/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('backend/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('backend/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('backend/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('backend/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('backend/vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('backend/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('backend/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('backend/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('backend/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- jQuery Tags Input -->
    <script src="{{ asset('backend/vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('backend/vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('backend/vendors/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Dropzone.js -->
    <script src="{{ asset('backend/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('backend/build/js/custom.min.js') }}"></script>
    <script src="{{ asset('backend/build/js/toastr.min.js') }}"></script>
    <script src="{{ asset('backend/build/js/my-js.js') }}"></script>
    <script type="text/javascript">
        if (typeof TYPE_MESSAGE != "undefined")
                {
                    switch (TYPE_MESSAGE) {
                        case 'success':
                        toastr.success(MESSAGE)
                        break;
                        case 'warning':
                        toastr.warning(MESSAGE)
                        break;
                        case 'info':
                        toastr.info(MESSAGE)
                        break;
                        case 'error':
                        toastr.error(MESSAGE)
                        break;
                    }
                }
    </script>
    @yield('script')
    @stack('tools')
    <script>
        {{--$("div#photo-dropzone").dropzone({--}}
        {{--        url: "{{ route('file.store_product_photos') }}",--}}
        {{--        headers: {--}}
        {{--            'x-csrf-token': '{{ csrf_token() }}',--}}
        {{--        },--}}
        {{--        paramName: 'photo',--}}
        {{--        parallelUploads: 3,--}}
        {{--        // maxFilesize: 0.2,--}}
        {{--        // maxFiles: 3,--}}
        {{--        acceptedFiles: 'image/*',--}}
        {{--        // previewTemplate: document.querySelector('#preview').innerHTML,--}}
        {{--        addRemoveLinks: true,--}}
        {{--        dictDefaultMessage: 'Click here or drop files here to upload!',--}}
        {{--        dictRemoveFile: 'Remove file',--}}
        {{--        // dictFileTooBig: 'Image is larger than 200Kb',--}}
        {{--        dictRemoveFileConfirmation: 'Are you sure?',--}}
        {{--        timeout: 10000,--}}

        {{--        init: function () {--}}
        {{--            this.on("removedfile", function (file) {--}}
        {{--                $('#'+file.serverFileUuid).remove();--}}
        {{--                $.post({--}}
        {{--                    url: "{{ route('file.delete') }}",--}}
        {{--                    data: {--}}
        {{--                        uuid: file.serverFileUuid,--}}
        {{--                        _token: '{{ csrf_token() }}'--}}
        {{--                    },--}}
        {{--                    dataType: 'json',--}}
        {{--                    success: function (data) {--}}
        {{--                        if(data.status && data.status === 'success'){--}}
        {{--                            toastr.info('File '+ file.name +' was deleted!');--}}
        {{--                        }--}}
        {{--                    }--}}
        {{--                });--}}
        {{--            });--}}
        {{--        },--}}
        {{--        success: function (file, responseData) {--}}
        {{--            $('#photo-dropzone').append('<input type="hidden" id="'+responseData.uuid+'" name="uuid_photos[]"  value="'+responseData.uuid+'">');--}}

        {{--            file.serverFileUuid = responseData.uuid;--}}
        {{--            toastr.success('File '+ file.name +' uploaded successful!');--}}
        {{--        }--}}
        {{--    });--}}
    </script>
</body>

</html>
