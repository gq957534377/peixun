<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->head_img??'/dist/img/user2-160x160.jpg' }}" class="img-circle"
                     onerror='this.src="/dist/img/user2-160x160.jpg"' alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主菜单</li>
            <li @if(request()->path()=='trains') class="active" @endif>
                <a href="{{url('/trains')}}"><i class="fa fa-train"></i> <span>历年培训</span></a>
            </li>
            <li @if(request()->path()=='positions') class="active" @endif>
                <a href="{{url('/positions')}}"><i class="fa fa-graduation-cap"></i> <span>历年任职</span></a>
            </li>
            <li @if(request()->path()=='honors') class="active" @endif>
                <a href="{{url('/honors')}}"><i class="fa fa-trophy"></i> <span>历年荣誉</span></a>
            </li>
            {{--<li @if(request()->path()=='telescope') class="active" @endif>--}}
                {{--<a target="_blank" href="{{url('/telescope')}}"><i class="fa fa-fw fa-internet-explorer"></i> <span>访问管理</span></a>--}}
            {{--</li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<!-- =============================================== -->