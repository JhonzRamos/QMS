@extends('admin.layouts.master')
@section('title', 'New User')
@section('content')

    <h3 class="page-title">User</h3>

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

            <div class="box ">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus-circle fa-fw"></i>Add new User</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(array('route' => 'admin'.'.users.store', 'id' => 'form-with-validation')) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name*', array('class'=>'control-label')) !!}
                        {!! Form::text('name', old('name'), array('class'=>'form-control','disabled'=> isset($view) ? true : false))  !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email*', array('class'=>'control-label')) !!}

                        {!! Form::text('email', old('email'), array('class'=>'form-control','disabled'=> isset($view) ? true : false)) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password', array('class'=>'control-label')) !!}
                        {!! Form::password('password', array('class'=>'form-control','disabled'=> isset($view) ? true : false)) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('role_id', 'Role', array('class'=>'control-label')) !!}
                        {!! Form::select('role_id', $roles, old('role_id'), array('class'=>'form-control select2', 'width'=>'100' ,'disabled'=> isset($view) ? true : false)) !!}

                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::submit( 'Create' , array('class' => 'btn btn-primary')) !!}
                                {!! link_to_route('admin'.'.users.index', 'Cancel', null, array('class' => 'btn btn-default')) !!}
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
                    mode: "textareas",
                    editor_selector: "mceEditor",
                    editor_deselector: "mceNoEditor"
                });
            </script>
@endsection