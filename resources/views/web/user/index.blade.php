@extends ('layouts.master')

@section ('title', '人员管理')

@section('styles')
    <link rel="stylesheet" href="/sweet-alert/css/sweet-alert.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="/bower_components/bootstrap-daterangepicker/daterangepicker.css">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">

            <div class="col-sm-5">
                <h1>
                    人员管理
                    <small>列表</small>
                </h1>
            </div><!--col-->
            @if(in_array(\Illuminate\Support\Facades\Auth::user()->role,[\App\Models\User::Role_Admin,\App\Models\User::Role_Educator,\App\Models\User::Role_School]))
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" style="float: right;margin-top: 3%;" role="toolbar"
                     aria-label="Toolbar with button groups">
                    <a href="{{ route('users.create') }}" class="btn btn-success ml-1" data-toggle="tooltip"
                       title="Create New"><i class="fa fa-fw fa-plus"></i>添加人员</a>
                </div><!--btn-toolbar-->
            </div><!--col-->
            @endif
        </div><!--row-->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">


                    <!-- /.box-header -->
                    <div class="box-body">
                        @include('layouts.errors')
                        <form class="box-body col-lg-4" action="{{ route('users.index') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-6 margin-bottom">
                                    <select class="form-control input-group" name="school_id">
                                        <option value="">所有学校</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}"
                                                    @if(request('school_id')==$school->id) selected @endif>{{$school->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 margin-bottom">
                                    <select class="form-control input-group" name="role">
                                        <option value="">所有角色</option>
                                        @foreach($roles as $role)
                                            <option @if(request('role')==$role[0]) selected
                                                    @endif value="{{ $role[0] }}">{{$role[1]}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 margin-bottom">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="text" class="form-control" value="{{request('name')}}" name="name"
                                               placeholder="查询人员名称">
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-bottom">
                                    <button class="btn btn-primary margin-r-5">查询</button>
                                    <a href="{{request()->url()}}"><button type="button" class="btn btn-danger">清空筛选条件</button></a>
                                </div>
                            </div>
                        </form>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>编号</th>
                                <th>姓名</th>
                                <th>账号</th>
                                <th>手机</th>
                                <th>学校</th>
                                <th>角色</th>
                                <th>负责仓库</th>
                                <th>状态</th>
                                <th>上次登录时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->tel }}</td>
                                    <td>{!! $user->school->name??($user->schools_dom??'-') !!}</td>
                                    <td>{{ $user->role_name }}</td>
                                    <td>{!! $user->laboratories_dom !!}</td>
                                    <td>{{ $user->status_value }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        @switch(\Illuminate\Support\Facades\Auth::user()->role)
                                            @case(\App\Models\User::Role_Admin)
                                            @case(\App\Models\User::Role_School)
                                            <a href="{{route('users.edit', $user)}}" class="btn btn-primary"><i
                                                        class="fa fa-edit" data-toggle="tooltip" data-placement="top"
                                                        title="修改"></i>修改</a>

                                            <a href="javascript:;" data-id="{{$user->id}}"
                                               class="del dropdown-item btn btn-danger">删除</a>
                                            <button class="reset-pwd btn btn-success" data-id="{{$user->id}}">重置密码
                                            </button>
                                            @break
                                            @case(\App\Models\User::Role_Educator)
                                            @if($user->role==\App\Models\User::Role_School)
                                                <a href="{{route('users.edit', $user)}}" class="btn btn-primary"><i
                                                            class="fa fa-edit" data-toggle="tooltip"
                                                            data-placement="top"
                                                            title="修改"></i></a>

                                                <a href="javascript:;" data-id="{{$user->id}}"
                                                   class="del dropdown-item btn btn-danger">删除</a>
                                                <button class="reset-pwd btn btn-success" data-id="{{$user->id}}">重置密码
                                                </button>
                                            @endif
                                            @break
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="float-left">
                                    {!! $users->total() !!} 人共计
                                </div>
                            </div><!--col-->

                            <div class="col-5">
                                <div class="float-right">
                                    {!! $users->render() !!}
                                </div>
                            </div><!--col-->
                        </div><!--row-->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="/sweet-alert/js/sweet-alert.min.js"></script>
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
        $('#reservation').daterangepicker()
        $('.del').click(function () {
            var This = $(this);
            swal({
                title: '确定删除吗？',
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '确认',
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/users/' + This.data('id'),
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name=csrf-token]').attr('content'),
                        },
                        success: function (data) {
                            if (data.StatusCode === 200) {
                                swal({
                                    title: '成功！',
                                    text: "删除成功",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: '确认',
                                    closeOnConfirm: false
                                }, function (isConfirm) {
                                    window.location.reload();
                                });
                            } else {
                                alert(data.ResultData);
                            }

                        },
                        error: function (error) {
                            if (error.status === 422) {
                                alert(error.responseJSON.errors[Object.keys(error.responseJSON.errors)[0]][0]);
                                return;
                            }
                            alert('服务异常，请联系管理员');
                        }
                    });
                } else {
                    swal("取消", '已取消删除', "error");
                }
            });
        });
    </script>
@endsection
