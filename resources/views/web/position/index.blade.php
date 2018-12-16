@extends('layouts.master')
@section('title', '历年任职')
@section('styles')
  <link rel="stylesheet" href="/bower_components/bootstrap-fileinput/css/fileinput.css">
@endsection
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      历年任职信息
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
            <form class="box-body col-lg-8" action="{{ route('positions.index') }}" method="GET">
              <div class="row">
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" value="{{request('type')}}" class="form-control" name="type"
                           placeholder="查询任职类别">
                  </div>
                </div>
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" value="{{request('year')}}" class="form-control" name="year"
                           placeholder="查询年度">
                  </div>
                </div>
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" value="{{request('user_name')}}" class="form-control" name="user_name"
                           placeholder="查询职工名称">
                  </div>
                </div>
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" value="{{request('position')}}" class="form-control" name="position"
                           placeholder="查询职位名称">
                  </div>
                </div>
                <div class="col-lg-3 margin-bottom">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
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
                <th>职位</th>
                <th>人员名称</th>
                <th>联系方式</th>
                <th>团队名称</th>
                <th>任职类别</th>
                <th>备注</th>
              </tr>
              @foreach($positions as $position)
              <tr>
                <td>{{ $position->id }}</td>
                <td>{{ $position->year }}</td>
                <td>{{ $position->position }}</td>
                <td>{{ $position->user_name }}</td>
                <td>{{ $position->tel!=0 ?$position->tel: '' }}</td>
                <td><button class="btn btn-success">{{ $position->team }}</button></td>
                <td>{{ $position->type }}</td>
                <td>{{ $position->remark ?? '' }}</td>
              </tr>
              @endforeach
            </table>

            <div class="row">
              <div class="col-sm-1">
                <div class="float-left">
                  {!! $positions->total() !!}条 共计
                </div>
              </div><!--col-->
              <div class="col-sm-11">
                <div class="float-right">
                  {!! $positions->render() !!}
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
            url:"/positions/import",
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
  </script>
@stop