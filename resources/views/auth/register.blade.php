<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('admins/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admins/assets/vendor/linearicons/style.css') }}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('admins/assets/css/main.css') }}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{ asset('admins/assets/css/demo.css') }}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admins/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('admins/assets/img/favicon.png') }}">
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle">
                <div class="auth-box ">
                    <div class="left">
                        <div class="content">
                            <div class="header">
                            
                                <p class="lead">Register account</p>
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            <form id="register-form" class="form-auth-small" action="{{ route('register.store') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="reg-name" class="control-label sr-only">Name</label>
                                    <input type="text" class="form-control" id="reg-name" name="name"
                                        value="{{ old('name') }}" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="reg-email" class="control-label sr-only">Email</label>
                                    <input type="email" class="form-control" id="reg-email" name="email"
                                        value="{{ old('email') }}" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="reg-password" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control" id="reg-password" name="password"
                                        value="{{ old('password') }}" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="reg-confirm-password" class="control-label sr-only">Confirm
                                        Password</label>
                                    <input type="password" class="form-control" id="reg-confirm-password"
                                        name="password_confirmation" value="{{ old('password_confirmation') }}"
                                        placeholder="Confirm password">
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg btn-block">REGISTER</button>
                                <div class="bottom">
                                    <span class="helper-text"><i class="lnr lnr-user"></i> <a
                                            href="{{ route('login.auth') }}">Already have an account?</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="overlay"></div>
                        <div class="content text">
                            <h1 class="heading">Enjoy shopping</h1>
                            <p>with KLOROFIL</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    $('#register-form').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo: "#reg-password"
            }
        },
        messages: {
            password: {
                required: "Please enter password."
            },
            password_confirmation: {
                required: "Please enter password confirmation.",
                equalTo: "Please enter the same password."
            }
        }
    });
});
</script>

</html>