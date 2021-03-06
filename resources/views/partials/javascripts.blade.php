@inject('request', 'Illuminate\Http\Request')
<script>
    window.deleteButtonTrans = '{{ trans("quickadmin.qa_delete_selected") }}';
    window.copyButtonTrans = '{{ trans("quickadmin.qa_copy") }}';
    window.csvButtonTrans = '{{ trans("quickadmin.qa_csv") }}';
    window.excelButtonTrans = '{{ trans("quickadmin.qa_excel") }}';
    window.pdfButtonTrans = '{{ trans("quickadmin.qa_pdf") }}';
    window.printButtonTrans = '{{ trans("quickadmin.qa_print") }}';
    window.colvisButtonTrans = '{{ trans("quickadmin.qa_colvis") }}';
</script>
<script src="{{ url('plugins/jQuery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ url('plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="{{ url('plugins/bootstrap-4.0/js/bootstrap.js') }}"></script>
<script src="{{ url('js/lib/bootstrap-notify.min.js') }}"></script>
<script src="{{ url('plugins/architectui/js/main.js') }}"></script>
<script src="{{ url('js/all.min.js') }}"></script>
<script>
    window._token = '{{ csrf_token() }}';
</script>
<script>
    var page = '{{ $request->segment(2) }}';
    $.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.16/i18n/English.json"
        }
    });

    @if (auth()->check())
    $('#moneyFormat').maskMoney({
        // The symbol to be displayed before the value entered by the user
        prefix:'$',
        // The thousands separator
        thousands:',',
        // The decimal separator
        decimal:'.'
    }); 

    $('#expense').submit(function(){
        var value = $('#moneyFormat').maskMoney('unmasked')[0];
        $('#moneyFormat').val(value);
    });
    @endif
     

</script>

 



@yield('javascript')