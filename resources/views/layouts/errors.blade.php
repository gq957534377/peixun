@if (isset($errors) && count($errors) > 0)
        <div style="width: 100%;" class="alert alert-dismissable alert-danger">
            <button type="button" class="close" onclick="$('div.alert').remove()">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="line-24 f_14 font-weight-bolder">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@elseif(isset($errors) && count($errors->success) > 0)
    <div style="width: 100%;z-index:3;" class="alert alert-dismissable alert-success">
        <button type="button" class="close" onclick="$('div.alert').remove()">&times;</button>
        <ul>

            <li>{{ $errors->success->first() }}</li>
        </ul>
    </div>
@endif