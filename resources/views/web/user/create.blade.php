@extends ('layouts.master')

@section ('title', '添加账号')

@section('styles')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">

            <div class="col-sm-5">
                <h1>
                    人员管理
                    <small>添加</small>
                </h1>
            </div><!--col-->
        </div><!--row-->
    </section>

    <!-- Main content -->
    <section class="content">
        <form class="form-horizontal" method="post" action="{{route('users.store')}}" autocomplete="off">
            @include('layouts.errors')
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">姓名 *</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" required value="{{old('name')}}" class="form-control"
                               placeholder="姓名">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱 *</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" required value="{{old('email')}}" class="form-control"
                               id="inputEmail3"
                               placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">密码 *</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" required value="{{old('password')}}" class="form-control"
                               id="inputPassword3"
                               placeholder="Password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">手机*</label>
                    <div class="col-sm-10">
                        <input type="tel" required minlength="11" name="tel" maxlength="11" value="{{old('tel')}}"
                               class="form-control"
                               placeholder="手机号">
                    </div>
                </div>

                @if(\Illuminate\Support\Facades\Auth::user()->role==\App\Models\User::Role_School)
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">所属学校 *</label>
                        <div class="col-sm-10">
                            <select required class="form-control" name="school_id" select="{{old('school_id')}}" id="">
                                @foreach(\Illuminate\Support\Facades\Auth::user()->schools as $school)
                                    <option @if(old('school_id')==$school->id) selected
                                            @endif value="{{$school->id}}">{{$school->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                @if(!empty(Auth::user()->Roles))
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">角色*</label>
                        <div class="col-sm-10">
                            @foreach(Auth::user()->Roles as $role)
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="role" value="{{$role}}" checked="">
                                        {{\App\Models\User::roleName($role)}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
            {{--<div class="box-footer">--}}
                <center>
                    <button type="submit" class="btn btn-info">添加</button>
                    <button type="reset" class="btn btn-danger">重置</button>
                    <a href="{{ route('users.index') }}" class="btn btn-success">返回</a>
                </center>
            {{--</div>--}}
            <!-- /.box-footer -->
        </form>
    </section>
@endsection
@section('scripts')

@endsection
