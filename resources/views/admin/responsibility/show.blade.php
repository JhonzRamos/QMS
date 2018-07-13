@extends('admin.layouts.master')
@section('title', 'Responsibility Group')
@section('content')

     <h3 class="page-title">Responsibility Group</h3>

    <div class="row">
        <div class="col-md-12">

            @if (Session::has('message'))
                <div class="alert alert-info">
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif
            @if ($errors->count() > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


    <div class="box box-danger">
        <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-pencil fa-fw"></i>Responsibility Group</h3>
        </div>
        <div class="box-body">
            {!! Form::model($responsibility, array('id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array('admin'.'.responsibility.update', encrypt($responsibility->id)))) !!}

            <div class="form-group">
    {!! Form::label('sTitle', 'Responsibility Group Name*', array('class'=>'control-label')) !!}
        {!! Form::text('sTitle', old('sTitle',$responsibility->sTitle), array('class'=>'form-control','disabled'=> isset($view) ? true : false))  !!}
        
</div><div class="form-group">
    {!! Form::label('sDescription', 'Responsibility Group Description', array('class'=>'control-label')) !!}
        {!! Form::textarea('sDescription', old('sDescription',$responsibility->sDescription), array('class'=>'form-control mceEditor','disabled'=> isset($view) ? true : false))  !!}
        
</div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-12">
                     @if(!isset($view)){!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}@endif
                          {!! link_to_route('admin'.'.responsibility.index', 'Cancel', null, array('class' => 'btn btn-default')) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    </div>
            </div>
@endsection

@section('javascript')
<script src="{{asset('adminlte/plugins/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    tinymce.init({
        mode : "textareas",
        editor_selector : "mceEditor",
        editor_deselector : "mceNoEditor"
    });
</script>


@endsection