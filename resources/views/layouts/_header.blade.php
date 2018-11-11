<header class="main-header">
    <!-- Logo -->
    <a href="{{url('/')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ config('app.name', '危险化学品安全监管平台') }}</span>
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

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="/news" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">12</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">
                            你有 12新条消息
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="/news">
                                            <div class="pull-left">
                                                <img src=""
                                                     onerror='this.src="/dist/img/user2-160x160.jpg"' class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <h4>
                                                系统消息
                                                <small><i class="fa fa-clock-o"></i>2018-12-31 12:32:12</small>
                                            </h4>
                                            <p>hbfdhfdhfghdgfhj</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                            </ul>
                        </li>
                        <li class="footer"><a href="/">查看所有</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                {{--<li class="dropdown notifications-menu">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{--<i class="fa fa-bell-o"></i>--}}
                        {{--<span class="label label-warning">10</span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li class="header">You have 10 notifications</li>--}}
                        {{--<li>--}}
                            {{--<!-- inner menu: contains the actual data -->--}}
                            {{--<ul class="menu">--}}
                                {{--<li>--}}
                                    {{--<a href="#">--}}
                                        {{--<i class="fa fa-users text-aqua"></i> 5 new members joined today--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="footer"><a href="#">View all</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}

                {{--<!-- Tasks: style can be found in dropdown.less -->--}}
                {{--<li class="dropdown tasks-menu">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{--<i class="fa fa-flag-o"></i>--}}
                        {{--<span class="label label-danger">9</span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li class="header">You have 9 tasks</li>--}}
                        {{--<li>--}}
                            {{--<!-- inner menu: contains the actual data -->--}}
                            {{--<ul class="menu">--}}
                                {{--<li><!-- Task item -->--}}
                                    {{--<a href="#">--}}
                                        {{--<h3>--}}
                                            {{--Design some buttons--}}
                                            {{--<small class="pull-right">20%</small>--}}
                                        {{--</h3>--}}
                                        {{--<div class="progress xs">--}}
                                            {{--<div class="progress-bar progress-bar-aqua" style="width: 20%"--}}
                                                 {{--role="progressbar" aria-valuenow="20" aria-valuemin="0"--}}
                                                 {{--aria-valuemax="100">--}}
                                                {{--<span class="sr-only">20% Complete</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<!-- end task item -->--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li class="footer">--}}
                            {{--<a href="#">View all tasks</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ Auth::user()->head_img??'/dist/img/user2-160x160.jpg' }}" class="user-image"
                             onerror='this.src="/dist/img/user2-160x160.jpg"'>
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ Auth::user()->head_img??'/dist/img/user2-160x160.jpg' }}" class="img-circle"
                                 onerror='this.src="/dist/img/user2-160x160.jpg"' alt="User Image">

                            <h5>{{ Auth::user()->name }}</h5>
                            <h7>角色：管理员</h7>
                            <br>
                            <small>上次登录：{{Auth::user()->updated_at}}</small>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-8">
                                    <a href="#">安全指数：</a>
                                    <a href="#">85</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="javascript:;" class="reset-pwd"
                                       data-id="{{\Illuminate\Support\Facades\Auth::user()->id}}">重置密码</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{route('users.edit',\Illuminate\Support\Facades\Auth::user())}}"
                                   class="btn btn-default btn-flat">编辑资料</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"
                                   class="btn btn-default btn-flat">退出</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>