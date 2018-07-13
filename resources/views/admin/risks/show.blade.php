@extends('admin.layouts.master')
@section('title', 'Risk Register')
@section('content')

     <h3 class="page-title">Risk Register</h3>

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
        <h3 class="box-title"><i class="fa fa-pencil fa-fw"></i>Risk Register</h3>
        </div>
        <div class="box-body">
            {!! Form::model($risks, array('id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array('admin'.'.risks.update', encrypt($risks->id)))) !!}

            <div class="form-group">
    {!! Form::label('riskcategory_id', 'Risk Category*', array('class'=>'control-label')) !!}
        {!! Form::select('riskcategory_id', $riskcategory, old('riskcategory_id',$risks->riskcategory_id), array('class'=>'form-control select2', 'width'=>'100' ,'disabled'=> isset($view) ? true : false)) !!}
        
</div><div class="form-group">
    {!! Form::label('sRiskName', 'Risk Name*', array('class'=>'control-label')) !!}
        {!! Form::text('sRiskName', old('sRiskName',$risks->sRiskName), array('class'=>'form-control','disabled'=> isset($view) ? true : false))  !!}
        
</div><div class="form-group">
    {!! Form::label('sConsequence', 'Consequence*', array('class'=>'control-label')) !!}
        {!! Form::textarea('sConsequence', old('sConsequence',$risks->sConsequence), array('class'=>'form-control mceEditor','disabled'=> isset($view) ? true : false))  !!}
        
</div><div class="form-group">
    {!! Form::label('sPotentialCause', 'Potential Cause*', array('class'=>'control-label')) !!}
        {!! Form::textarea('sPotentialCause', old('sPotentialCause',$risks->sPotentialCause), array('class'=>'form-control mceEditor','disabled'=> isset($view) ? true : false))  !!}
        
</div><div class="form-group">
    {!! Form::label('risklikelihood_id', 'Likelihood*', array('class'=>'control-label')) !!}
        {!! Form::select('risklikelihood_id', $risklikelihood, old('risklikelihood_id',$risks->risklikelihood_id), array('class'=>'form-control select2', 'width'=>'100' ,'disabled'=> isset($view) ? true : false)) !!}
        
</div><div class="form-group">
    {!! Form::label('riskconsequence_id', 'Consequence*', array('class'=>'control-label')) !!}
        {!! Form::select('riskconsequence_id', $riskconsequence, old('riskconsequence_id',$risks->riskconsequence_id), array('class'=>'form-control select2', 'width'=>'100' ,'disabled'=> isset($view) ? true : false)) !!}
        
</div><div class="form-group">
    {!! Form::label('riskexposure_id', 'Risk Rating*', array('class'=>'control-label')) !!}
        {!! Form::select('riskexposure_id', $riskexposure, old('riskexposure_id',$risks->riskexposure_id), array('class'=>'form-control select2', 'width'=>'100' ,'disabled'=> isset($view) ? true : false)) !!}
        
</div><div class="form-group">
    {!! Form::label('sEvaluation', 'Analysis/Evaluation', array('class'=>'control-label')) !!}
        {!! Form::textarea('sEvaluation', old('sEvaluation',$risks->sEvaluation), array('class'=>'form-control mceEditor','disabled'=> isset($view) ? true : false))  !!}
        
</div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-12">
                     @if(!isset($view)){!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}@endif
                          {!! link_to_route('admin'.'.risks.index', 'Cancel', null, array('class' => 'btn btn-default')) !!}
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