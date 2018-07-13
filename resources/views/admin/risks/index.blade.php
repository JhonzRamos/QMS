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
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-warning fa-fw"></i>Risk Register</h3>
                </div>
                <div class="box-body">
                    <div class="flexigrid">
                        <div class="row">
                            <div class="tDiv3 col-md-12 " style="margin: 0 0 10px;text-align: left;">
                                <div class="btn-group">
                                    <!-- Button Export  -->
                                    <a class="export-anchor btn btn-success"
                                       data-url="#"
                                       target="_blank">
                                        <i class="fa fa-file-excel-o"></i>
                                        <span class="export">Export</span>
                                    </a>
                                    <!-- Akhir Button Export  -->
                                    <a class="print-anchor btn btn-primary"
                                       data-url="#">
                                        <i class="fa fa-print"></i>
                                        <span class="print">Print</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-responsive table-bordered" id="RisksDataTable">
                        <thead>
                        <tr>
                            <th>
                                {!! Form::checkbox('delete_all',1,false,['class' => 'mass']) !!}
                            </th>
                            <th>Risk ID</th>
                            <th>Risk Category</th>
                            <th>Risk Name</th>
                            <th>Consequence</th>
                            <th>Potential Cause</th>
                            <th>Likelihood</th>
                            <th>Consequence</th>
                            <th>Risk Rating</th>
                            <th>Analysis/Evaluation</th>

                            <th>
                                <div class="btn-group tools">
                                    @can('risks_create')
                                    <button action="form" type="button"
                                            onclick="location.href ='{{ route('admin'.'.risks.create') }}'"
                                            class="btn btn-default btn-sm fa">+
                                    </button>
                                    @endcan
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle btn-default btn-sm fa fa-bars"
                                                data-toggle="dropdown" aria-expanded="false"></button>
                                        <ul class="dropdown-menu pull-right ColumnToggle" role="menu">
                                            <li action="form" data-column="1" class="toggle-vis Checked"><a
                                                        href="javascript:void(0)"><i class="fa fa-check"></i>Risk
                                                    Category</a></li>
                                            <li action="form" data-column="2" class="toggle-vis Checked"><a
                                                        href="javascript:void(0)"><i class="fa fa-check"></i>Risk
                                                    Name</a></li>
                                            <li action="form" data-column="3" class="toggle-vis Checked"><a
                                                        href="javascript:void(0)"><i class="fa fa-check"></i>Likelihood</a>
                                            </li>
                                            <li action="form" data-column="4" class="toggle-vis Checked"><a
                                                        href="javascript:void(0)"><i class="fa fa-check"></i>Consequence</a>
                                            </li>
                                            <li action="form" data-column="5" class="toggle-vis Checked"><a
                                                        href="javascript:void(0)"><i class="fa fa-check"></i>Risk Rating</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($risks as $row)
                            <tr>
                                <td>
                                    {!! Form::checkbox('del-'.encrypt($row->id),1,false,['class' => 'single','data-id'=> encrypt($row->id)]) !!}
                                </td>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->riskcategory->sTitle}}</td>
                                <td>{{ $row->sRiskName }}</td>
                                <td>{!!$row->sConsequence !!}</td>
                                <td>{!! $row->sPotentialCause !!}</td>
                                <td>{{ isset($row->risklikelihood->sTitle) ? $row->risklikelihood->sTitle : '' }}</td>
                                <td>{{ isset($row->riskconsequence->sTitle) ? $row->riskconsequence->sTitle : '' }}</td>
                                <td><span class="label" style="background-color: {{ isset($row->riskexposure->sBackgroundColor) ? $row->riskexposure->sBackgroundColor : '#fff' }} ;"> {{ isset($row->riskexposure->sTitle) ? $row->riskexposure->sTitle : '' }}</span></td>
                                <td>{!!$row->sEvaluation !!}</td>
                                <td>

                                    <div class="btn-group tools">
                                        @can('risks_view')
                                        <button type="button"
                                                onclick="location.href ='{{route('admin'.'.risks.show', array(encrypt($row->id))) }}'"
                                                class="btn btn-default btn-sm fa fa-search"></button>
                                        @endcan
                                        @if(Gate::allows('risks_edit') || Gate::allows('risks_delete'))
                                            <div class="btn-group">
                                                <button class="btn dropdown-toggle btn-default btn-sm fa fa-bars"
                                                        data-toggle="dropdown"></button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    @can('risks_edit')
                                                    <li action="form"><a
                                                                href="{{route('admin'.'.risks.edit', array(encrypt($row->id))) }}"><i
                                                                    class="fa fa-pencil-square-o"></i>Edit</a></li>
                                                    @endcan
                                                    @can('risks_delete')
                                                    <li action="delete"><a href="#" data-toggle="modal"
                                                                           id="{{encrypt($row->id)}}"
                                                                           data-route="{{route('admin'.'.risks.destroy', encrypt($row->id))}}"
                                                                           data-target="#mDelete">
                                                            <i class="fa fa-minus"></i>Delete</a></li>
                                                    @endcan
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xs-12">
                            @can('risks_delete')
                            <button class="btn btn-danger" id="delete">Delete checked</button>
                            @endcan
                        </div>
                    </div>
                    {!! Form::open(['route' => 'admin'.'.risks.massDelete', 'method' => 'post', 'id' => 'massDelete']) !!}
                    <input type="hidden" id="send" name="toDelete">
                    {!! Form::close() !!}
                </div>
            </div>
            <div id="eModalContainer">
                <div class="modal fade" id="mDelete">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            {!! Form::open(array('method' => 'DELETE', 'id' => 'deleteEntry')) !!}

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Delete</h4>
                            </div>
                            <div class="modal-body">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <p id="deleteMessage"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                                </button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            $('#delete').click(function () {
                if (window.confirm('Are you sure you want to delete the items?')) {
                    var send = $('#send');
                    var mass = $('.mass').is(":checked");
                    if (mass == true) {
                        send.val('mass');
                    } else {
                        var toDelete = [];
                        $('.single').each(function () {
                            if ($(this).is(":checked")) {
                                toDelete.push($(this).data('id'));
                            }
                        });
                        send.val(JSON.stringify(toDelete));
                    }
                    $('#massDelete').submit();
                }
            });
            var table = $('#RisksDataTable').DataTable({
                "columnDefs": [{
                    "width": "30px",
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "visible": true
                }, {"targets": 1, "searchable": true, "orderable": true, "visible": true}, {
                    "targets": 2,
                    "searchable": true,
                    "orderable": true,
                    "visible": true
                }, {"targets": 2, "searchable": true, "orderable": true, "visible": true}, {
                    "targets": 2,
                    "searchable": true,
                    "orderable": true,
                    "visible": true
                }, {"targets": 3, "searchable": true, "orderable": true, "visible": true}, {
                    "targets": 4,
                    "searchable": true,
                    "orderable": true,
                    "visible": true
                }, {"targets": 5, "searchable": true, "orderable": true, "visible": true}, {
                    "targets": 5,
                    "searchable": true,
                    "orderable": true,
                    "visible": true
                }, {"width": "200px", "targets": 6, "searchable": false, "orderable": false, "visible": true}]
            });
            $('.toggle-vis').on('click', function (e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column($(this).attr('data-column'));

                // Toggle the visibility
                column.visible(!column.visible());


                if (!column.visible() == true) {
                    $(this).removeClass('Checked');
                } else {
                    $(this).addClass('Checked');
                }

            });
        });
    </script>
    <script>
        $('#mDelete').on('show.bs.modal', function (e) {
            var id = e.relatedTarget.id,
                    name = 'this entry',
                    modal = $(this);
            $('#deleteMessage').replaceWith(' <p> Comfirm delete ' + name + ' ?</p>');
            $('#deleteEntry').attr('action', e.relatedTarget.dataset.route);
        });
    </script>
@stop