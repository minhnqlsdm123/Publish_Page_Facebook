<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="{{ asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('backend/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('backend/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('backend/build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/build/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/build/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    @if(session('toastr'))
    <script>
        var TYPE_MESSAGE = "{{session('toastr.type')}}";
        var MESSAGE      = "{{session('toastr.message')}}";
    </script>
    @endif
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="POST">
                        @csrf
                        <h1>Login Form</h1>
                        <div>
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                required="" />
                        </div>
                        <div>
                            <button class="btn btn-success submit" href="index.html">Log in</button>
                            <button id="btn-login" type="button" class="btn btn-primary btn-lg">
                                <span> Login with Facebook</span>
                            </button>
                            {{-- <a class="reset_pass" href="#">Lost your password?</a> --}}
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">New to site?
                                <a href="#signup" class="to_register"> Quay lại website </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-paw"></i> Hi!</h1>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <form>
                        <h1>Create Account</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="index.html">Submit</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="#signin" class="to_register"> Log in </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and
                                    Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('backend/build/js/toastr.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({cache: true}); // since I am using jquery as well in my app
        $.getScript('//connect.facebook.net/en_US/sdk.js', function () {
            // initialize facebook sdk
            FB.init({
                appId: '368944207874648', // replace this with your id
                status: true,
                cookie: true,
                version: 'v2.8'
            });

            // attach login click event handler
            $("#btn-login").click(function () {
                FB.login(processLoginClick, {scope: 'public_profile,email,user_friends', return_scopes: true});
            });
        });

// function to send uid and access_token back to server
// actual permissions granted by user are also included just as an addition
        function processLoginClick(response) {
            var uid = response.authResponse.userID;
            var access_token = response.authResponse.accessToken;
            var permissions = response.authResponse.grantedScopes;
            var data = {
                uid: uid,
                access_token: access_token,
                _token: '{{ csrf_token() }}', // this is important for Laravel to receive the data
                permissions: permissions
            };
            postData("{{ url('/admin-login/login') }}", data, "post");
        }

// function to post any data to server
        function postData(url, data, method) {
            method = method || "post";
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", url);
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", data[key]);
                    form.appendChild(hiddenField);
                }
            }
            document.body.appendChild(form);
            form.submit();
        }
    })

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

</html>
