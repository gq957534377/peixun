<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title',config('app.name', '危险化学品安全监管平台'))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/sweet-alert/css/sweet-alert.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
    @include('layouts._header')
    <div class="content-wrapper">
        @yield('content')
        @include('layouts.reset_pwd')
    </div>
    {{--@include('layouts._footer')--}}
    @include('layouts._nav')
</div>
<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/dist/js/demo.js"></script>
<script src="/sweet-alert/js/sweet-alert.min.js"></script>
@yield('scripts')
</body>
<script>
    $('.reset-pwd').click(function () {
        $('#modal-reset-pwd').modal('show');
        $('#user-id-val').val($(this).data('id'));
    });
    $('#reset-pwd-sub').click(function () {
        var password = $('#password-val').val();
        if (!password || password.length < 6) {
            alert('请输入至少6位的密码');
            return false;
        }
        $.ajax({
            url: '/reset_pwd/' + $('#user-id-val').val(),
            type: 'post',
            data: {
                password: password,
                _token: "{{csrf_token()}}"
            },
            success: function (data) {
                if (data.StatusCode === 200) {
                    $('#modal-reset-pwd').modal('hide');
                    swal("成功", '重置成功', "success");
                } else {
                    alert(data.ResultData);
                }
            },
            error: function (error) {
                if (error.status===422){
                    alert(error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0]);
                    return ;
                }
                alert('服务异常，请联系管理员');
            }
        });
    });
</script>
</html>