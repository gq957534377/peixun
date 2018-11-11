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
                    <small>编辑</small>
                </h1>
            </div><!--col-->
        </div><!--row-->
    </section>

    <!-- Main content -->
    <section class="content">
        <form class="form-horizontal" method="post" action="{{route('users.update',$user)}}">
            @include('layouts.errors')
            <div class="box-body">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">姓名 *</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" required class="form-control" value="{{$user->name}}"
                               placeholder="姓名">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱 *</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" required class="form-control" value="{{$user->email}}"
                               id="inputEmail3"
                               placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">手机*</label>
                    <div class="col-sm-10">
                        <input type="tel" required minlength="11" name="tel" value="{{$user->tel}}" maxlength="11"
                               class="form-control"
                               placeholder="手机号">
                    </div>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->role==\App\Models\User::Role_School)
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">所属学校 *</label>
                        <div class="col-sm-10">
                            <select required class="form-control" name="school_id" select="{{$user->school_id}}" id="">
                                @foreach(\Illuminate\Support\Facades\Auth::user()->schools as $school)
                                    <option @if($user->school_id==$school->id) selected
                                            @endif value="{{$school->id}}">{{$school->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                @if($user->id!=\Illuminate\Support\Facades\Auth::user()->id)
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">角色*</label>
                        <div class="col-sm-10">
                            @foreach(Auth::user()->Roles as $role)
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="role" value="{{$role}}"
                                               @if($user->role==$role) checked @endif>
                                        {{\App\Models\User::roleName($role)}}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 control-label">头像</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <a href="javascript:void(0);" id="banner"><img id="banner_up-img"
                                                                           src="{{$user->head_img??'/upLoad.jpg'}}"
                                                                           onerror='this.src="/upLoad.jpg"'/></a>
                        </div>
                        <input required type="hidden" name="head_img" value="{{$user->head_img}}"
                               id="banner_up">
                    </div><!--form-group-->
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <center>
                    <button type="submit" class="btn btn-info">保存</button>
                </center>
            </div>
            <!-- /.box-footer -->
        </form>
    </section>
    <div id="zxzApp"></div>
    <div id="banner_up_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close-model" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">上传头像</h4>
                </div>
                <div class="modal-body">
                    <div class="container_crop">
                        <div class="imageBox">
                            <div class="thumbBox"></div>
                            <div class="spinner" style="display: none"><span class="font-18" style="">Loading...</span>
                            </div>
                        </div>
                        <div class="action">
                            <!-- <input type="file" id="file" style=" width: 200px">-->
                            <div class="new-contentarea tc">
                                <a href="javascript:void(0)" class="upload-img"> <label
                                            for="upload-file">选择图像</label>
                                </a> <input type="file" class="" name="upload-file" id="upload-file"/>
                            </div>
                            <input type="button" id="btnCrop" class="Btnsty_peyton" value="裁切">
                            <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+">
                            <input type="button" id="btnZoomOut" class="Btnsty_peyton"
                                   value="-">
                        </div>
                        {{--<div class="cropped"></div>--}}
                    </div>
                    <div class="view-mail">
                        <br>
                        <p id="show-content"></p>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script src="/crop.min.js"></script>
    <script type="text/javascript">
        window.zxzIsGood = function (data, field) {
            if (data.StatusCode === 200) {
                $('#banner_up-img').attr('src', data.ResultData);
                $('#banner_up').val(data.ResultData);
                $('.vicp-icon4').trigger('click');
            } else {
                alert(data.ResultData);
            }
        }
    </script>

@endsection
