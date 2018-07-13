@extends('admin.layouts.master')
@section('title', 'Strategies')
@section('content')

     <h3 class="page-title">Strategies</h3>

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

 <div class="box box-primary ">
        <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-plus-circle fa-fw"></i>Add new Strategies</h3>
        </div>
        <div class="box-body">
         {!! Form::open(array('route' => 'admin'.'.strategies.store', 'id' => 'form-with-validation')) !!}
            <div class="form-group">
    {!! Form::label('sTitle', 'Strategy Title*', array('class'=>'control-label')) !!}
        {!! Form::text('sTitle', old('sTitle'), array('class'=>'form-control','disabled'=> isset($view) ? true : false))  !!}
        
</div><div class="form-group">
    {!! Form::label('sDescription', 'Strategy Description', array('class'=>'control-label')) !!}
        {!! Form::textarea('sDescription', old('sDescription'), array('class'=>'form-control mceEditor','disabled'=> isset($view) ? true : false))  !!}
        
</div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-12">
                  {!! Form::submit( 'Create' , array('class' => 'btn btn-primary')) !!}
                   {!! link_to_route('admin'.'.strategies.index', 'Cancel', null, array('class' => 'btn btn-default')) !!}
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