<script>
//    window.deleteButtonTrans = 'Delete';
//    window.copyButtonTrans = 'Copy';
//    window.csvButtonTrans = 'CSV';
//    window.excelButtonTrans = 'Excel';
//    window.pdfButtonTrans = 'PDF';
//    window.printButtonTrans = 'Print';
//    window.colvisButtonTrans = 'Columns';
</script>
<script src="{{asset('js/jquery.js')}}"></script>
{{--<script src="{{asset('quickadmin/js/jquery.min.js')}}"></script>--}}
<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
{{--<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>--}}
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
{{--<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>--}}
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<!-- Bootstrap-Iconpicker Iconset -->
<script type="text/javascript" src="{{ url('adminlte/plugins/fa_picker/js/fontawesome-iconpicker.min.js') }}"></script>
<!-- Bootstrap-Iconpicker -->
<script type="text/javascript" src="{{ url('adminlte/plugins/fa_picker/js/fontawesome-iconpicker.min.js') }}"></script>
<!-- date-time-picker -->
<script src="{{asset('third_party/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap Toggle -->
<script src="{{asset('third_party/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
<!-- Bootstrap Color Picker-->
<script src="{{asset('adminlte/plugins/colorpicker/bootstrap-colorpicker.js')}}"></script>
<!-- Bootstrap Time Picker-->
<script src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('adminlte/plugins/iCheck/icheck.js')}}"></script>
<!-- fancybox -->
<script src="{{asset('adminlte/plugins/fancybox/jquery.fancybox.js')}}"></script>
<!--Alertify JS-->
<script src="{{asset('quickadmin/js/alertify.min.js')}}"></script>

<script src="{{ url('/adminlte/js') }}/mapInput.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDS9Rw1-ETYlawypeBrNVJlM1k_r3vw038&amp;libraries=places&amp;callback=initialize" async="" defer=""></script>
<script src="{{ url('adminlte/js') }}/bootstrap.min.js"></script>
<script src="{{ url('adminlte/js') }}/select2.full.min.js"></script>
<script src="{{ url('adminlte/js') }}/main.js"></script>

<script src="{{ url('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ url('adminlte/js/app.min.js') }}"></script>
<script>
    window._token = '{{ csrf_token() }}';
</script>
<script>
    $.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.16/i18n/English.json"
        }
    });


    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        dateFormat: "{{ config('quickadmin.date_format_jquery') }}"
    });

    $('.datetimepicker').datetimepicker({
        autoclose: true,
        dateFormat: "{{ config('quickadmin.date_format_jquery') }}",
        timeFormat: "{{ config('quickadmin.time_format_jquery') }}"
    });

//    $('.checkbox').iCheck({ checkboxClass: 'icheckbox_square-blue' });

    $( ".select2" ).select2();

  $('#datatable').dataTable( {
        "language": {
            "url": "{{ trans('quickadmin::strings.datatable_url_language') }}"
        }
    });




        $('.colorpicker').colorpicker();

    //Timepicker
    $('.timepicker').timepicker({

    })

    //

    $('.fileinput-button').addClass('btn btn-success').prepend('<i class="fa fa-upload"></i> ');





</script>
{{--<script>--}}
    {{--$(document).ready(function () {--}}
{{--//        var url = site + '/' + ur_class + '/' + url_function;--}}
{{--//--}}
{{--//        $('ul.sidebar-menu a').filter(function() {--}}
{{--//            return this.href == url;--}}
{{--//        }).parent().addClass('active');--}}

        {{--$('.treeview li.active').parent().parent().addClass('active');--}}
        {{--$('.treeview .level-2 li.active').parent().parent().parent().parent().addClass('active');--}}

        {{--//list.js--}}
        {{--var options = {--}}
            {{--searchClass: ['searchlist'],--}}
            {{--valueNames: [ 'treeview' ]--}}
        {{--};--}}
        {{--$("#searchSidebar").focus(function() {--}}


            {{--menune = $('.treeview').parent().clone();--}}
            {{--$('#menuList').html(menune);--}}
            {{--$('#menuSub').hide();--}}


            {{--var menuSidebarList = new List('menuSidebar', options);--}}
        {{--}).focusout(function() {--}}
            {{--if (!$(this).val()) {--}}
                {{--$('#menuList').html('');--}}
                {{--$('#menuSub').show();--}}
            {{--};--}}
        {{--});--}}
        {{--// $('.slimScrollDiv').mouseleave(function() {--}}
        {{--//     $('#searchSidebar').val('');--}}
        {{--// });--}}

        {{--//grocery fix bug--}}
        {{--$('.chzn-container').css('width', '100%');--}}
        {{--$('.chzn-drop').css('width', '100%');--}}
        {{--$('.chzn-search input').css('width', '100%');--}}
        {{--$('.fileinput-button').removeClass('qq-upload-button').addClass('btn btn-success').prepend('<i class="fa fa-upload"></i> ');--}}
        {{--$('#fancybox-outer').css('width','107%');--}}
    {{--});--}}
{{--</script>--}}
