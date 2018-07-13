@extends('admin.layouts.master')
@section('title', 'Risk Matrix')
@section('content')

    <h3 class="page-title">Risk Matrix</h3>

    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-6">

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
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-warning fa-fw"></i>Risk Matrix</h3>
                </div>
                <form method="post" action="{{url('admin/riskmatrix/create')}}">
                    {{csrf_field()}}
                <div class="box-body">

                    <table class="table">
                        <tfoot>
                        <tr>
                            <td></td>
                        @foreach($likelihood as $key => $col)
                            <td><a href="#" style="color: #000;" data-toggle="popover" title="<b>{{$col->sTitle}}</b>"  data-html="true" data-content="{{$col->sDescription }}"><b>{{$col->sTitle}}</b></a></td>
                        @endforeach
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($consequence as  $key1 => $row)
                            <tr>
                                <td ><a href="#" style="color: #000;"  data-toggle="popover" title="<b>{{$row->sTitle}}</b>"  data-html="true" data-content="{{$row->sDescription }}"><b>{{$row->sTitle}}</b></a></td>
                                @foreach($likelihood as $key2 =>$col)
                                    <td>
                                        <div class="btn-group" >
                                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="min-width: 100px; min-height: 100px;">
                                                Please Select <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @foreach($rating as $key3 =>$row2)
                                                <li><a href="#" data-id="{{$row2->id}}" style="color: #000; background-color: {{$row2->sBackgroundColor}};">{{$row2->sTitle}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <input type="hidden" name="consequence_ids[]" value="{{$row->id}}">
                                        <input type="hidden" name="likelihood_ids[]" value="{{$col->id}}">
                                        <input type="hidden" name="rating_ids[]" value="">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-default" id="back">Back</button>
                            <button type="submit" class="btn btn-primary" id="save">Save Changes</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();

            $(".dropdown-menu li a").click(function(e){
                console.log( $(this).closest( ".btn-group ").find("a").first());

                var bg_color = $(this).context.style.backgroundColor;
                var text = $(this).text();

                //$(".btn:first-child").html($(this).text()+' <span class="caret"></span>').css( "background-color", bg_color );
                $(this).closest( ".btn-group").find("a").first().css( "background-color", bg_color ).css( "color", '#000').html(text+' <span class="caret"></span>');
            });
        });
    </script>
<script>


</script>
@stop