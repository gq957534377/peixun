@extends ('layouts.master')

@section ('title', '历年培训')

@section('styles')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">

            <div class="col-sm-5">
                <h1>
                    历年培训
                </h1>
            </div><!--col-->
        </div><!--row-->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('layouts.errors')
        <form class="form-horizontal" method="post" action="{{ route('trains.update',$train) }}">
            <div class="box-body">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-lg-4 margin-bottom">
                        <label>年度</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$train->year}}"
                                   placeholder="年度" name="year">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>类别</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$train->case}}"
                                   placeholder="类别" name="case">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>团队名称</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$train->team}}"
                                   placeholder="团队名称" name="team">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>学生名称</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$train->student}}"
                                   placeholder="年度" name="student">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>学生电话</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control"
                                   value="{{$train->student_tel}}"
                                   placeholder=学生电话 name="student_tel">
                        </div>
                    </div>
                    <div class="col-lg-4 margin-bottom">
                        <label>备注</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" class="form-control submission" value="" name="备注" placeholder="请填写备注">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <center>
                <button type="submit" class="btn btn-info">更新</button>
                <button type="reset" class="btn btn-danger">重置</button>
                <a href="{{ route('trains.index') }}" class="btn btn-success">返回</a>
            </center>
        </form>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
