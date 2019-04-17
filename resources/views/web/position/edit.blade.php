@extends ('layouts.master')

@section ('title', '历年任职')

@section('styles')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">

            <div class="col-sm-5">
                <h1>
                    历年任职
                </h1>
            </div><!--col-->
        </div><!--row-->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('layouts.errors')
        <form class="form-horizontal" method="post" action="{{ route('positions.update',$position) }}">
            <div class="box-body">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-lg-4 margin-bottom">
                        <label>年度</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$position->year}}"
                                   placeholder="年度" name="year">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>职位类别</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$position->type}}"
                                   placeholder="职位类别" name="type">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>团队名称</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$position->team}}"
                                   placeholder="团队名称" name="team">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>人员名称</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$position->user_name}}"
                                   placeholder="人员名称" name="user_name">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>联系电话</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$position->tel}}"
                                   placeholder=联系电话 name="tel">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>职位名称</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$position->position}}"
                                   placeholder="职位名称" name="position">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>备注</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" class="form-control submission" name="remark" value="{{$position->remark}}" placeholder="请填写备注">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <center>
                <button type="submit" class="btn btn-info">更新</button>
                <button type="reset" class="btn btn-danger">重置</button>
                <a href="{{ route('positions.index') }}" class="btn btn-success">返回</a>
            </center>
        </form>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
