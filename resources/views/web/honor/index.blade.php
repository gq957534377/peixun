@extends('layouts.master')
@section('title', '历年任职')
@section('styles')
  <link rel="stylesheet" href="/bower_components/bootstrap-fileinput/css/fileinput.css">
@endsection
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      历年获得荣誉信息
      <small>列表</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            @include('layouts.errors')
            <form class="box-body col-lg-8" action="{{ route('honors.index') }}" method="GET">
              <div class="row">
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                    <select class="form-control" name="year" id="">
                      <option value="">查询年度</option>
                      @foreach(\App\Models\Honor::yearList() as $item)
                        <option @if(request('year') == $item) selected @endif value="{{$item}}">{{ $item }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-trophy"></i></span>
                    <input type="text" value="{{request('name')}}" class="form-control" name="name"
                           placeholder="查询荣誉名称">
                  </div>
                </div>
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" value="{{request('user_name')}}" class="form-control" name="user_name"
                           placeholder="查询职工名称">
                  </div>
                </div>
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                    <input type="text" value="{{request('team')}}" class="form-control" name="team"
                           placeholder="查询服务队名称">
                  </div>
                </div>
                <div class="col-lg-6 margin-bottom">
                  <button class="btn btn-primary margin-r-5">查询</button>
                  <a href="{{request()->url()}}">
                    <button type="button" class="btn btn-danger">清空筛选条件</button>
                  </a>
                  <button type="button" class="btn btn-success" data-toggle="modal"
                          data-target="#import">导入数据</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tr>
                <th>序号</th>
                <th>年度</th>
                <th>荣誉名称</th>
                <th>人员名称</th>
                <th>团队名称</th>
                <th>备注</th>
                <th>操作</th>
              </tr>
              @foreach($honors as $honor)
              <tr>
                <td>{{ $honor->id }}</td>
                <td>{{ $honor->year }}</td>
                <td>{{ $honor->name }}</td>
                <td>{{ $honor->user_name }}</td>
                <td><button class="btn btn-success">{{ $honor->team }}</button></td>
                <td>{{ $honor->remark ?? '' }}</td>
                <td>
                  <a href="{{route('honors.edit', $honor)}}" class="btn btn-primary">
                    <i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="修改"></i>
                    修改</a>
                  <a href="javascript:;" data-id="{{$honor->id}}"
                     class="del dropdown-item btn btn-danger">删除</a>
                </td>
              </tr>
              @endforeach
            </table>

            <div class="row">
              <div class="col-sm-1">
                <div class="float-left">
                  {!! $honors->total() !!}条 共计
                </div>
              </div><!--col-->
              <div class="col-sm-11">
                <div class="float-right">
                  {!! $honors->render() !!}
                </div>
              </div><!--col-->
            </div><!--row-->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>

  </section>
  <!-- /.content -->
  <!--导入数据操作层-->
  <div id="import" class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">文件导入</h4>
        </div>
        <div class="modal-body">
          <form id="formImport" method="post">
              <input id="excelFile" type="file" name="file">
          </form>

          <!--数据显示表格-->
          <table id="gridImport" class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" border="0">
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          <button type="button" class="btn btn-primary" onclick="saveImport()">保存</button>
        </div>
      </div>
    </div>
  </div>
@stop
@section('scripts')
  <script src="/bower_components/bootstrap-fileinput/js/fileinput.js"></script>
  <script src="/bower_components/bootstrap-fileinput/js/locales/zh.js"></script>
  <script>
    function saveImport() {
        var file = $('#excelFile').val();
        if(file.length == 0) {
            alert('请选择文件！');
            return false;
        }
        var formData = new FormData();
        formData.append("file", document.getElementById("excelFile").files[0]);
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url:"/honors/import",
            type:"post",
            data:formData,
            processData:false,
            contentType:false,
            success:function(data){
                if(data.code == 200) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('状态码：'+data.code+'，'+data.message);
                }
            },
            error:function(e){
                alert("导入数据失败！！");
            }
        });
    }
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
                    url: '/honors/' + This.data('id'),
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
                            swal({
                                title: data.ResultData,
                                text: data.StatusCode,
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: '确认',
                                closeOnConfirm: false
                            });

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
@stop