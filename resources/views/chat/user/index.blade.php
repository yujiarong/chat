@extends('layouts.main')
@section('content')
<!--DataTables [ OPTIONAL ]-->
<link href={{ asset('nifty/plugins/datatables/media/css/dataTables.bootstrap.css') }}  rel="stylesheet">
<link href={{ asset('nifty/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css') }} rel="stylesheet">
<link href={{ asset("nifty/plugins/animate-css/animate.min.css") }}  rel="stylesheet">
              {{--   <div id="page-head">
                    
                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Static Tables</h1>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->


                    <!--Breadcrumb-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <ol class="breadcrumb">
                    <li><a href="#"><i class="demo-pli-home"></i></a></li>
                    <li><a href="#">Tables</a></li>
                    <li class="active">Static Tables</li>
                    </ol>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End breadcrumb-->

                </div> --}}
                <div id="page-content">
                    <!-- Basic Data Tables -->
                    <!--===================================================-->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">聊天室用户管理</h3>
                        </div>

                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th class="min-tablet">IP</th>
                                        <th class="min-tablet">Creat Time</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                </div>
@endsection

@section('scripts')
<!--DataTables [ OPTIONAL ]-->
<script src={{ asset("nifty/plugins/datatables/media/js/jquery.dataTables.js") }} ></script>
<script src={{ asset("nifty/plugins/datatables/media/js/dataTables.bootstrap.js") }} ></script>
<script src={{ asset("nifty/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js") }} ></script>
<script type="text/javascript">

$(document).on('nifty.ready', function() {


    // DATA TABLES
    // =================================================================
    // Require Data Tables
    // -----------------------------------------------------------------
    // http://www.datatables.net/
    // =================================================================

    $.fn.DataTable.ext.pager.numbers_length = 5;


    // Basic Data Tables with responsive plugin
    // -----------------------------------------------------------------
    
    var rowSelection = $('#demo-dt-basic').DataTable({
        "responsive": true,
        "language": {
            "paginate": {
              "previous": '<i class="demo-psi-arrow-left"></i>',
              "next": '<i class="demo-psi-arrow-right"></i>'
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '{{ route("chat.user.tableGet") }}',
            type: 'post'
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'ip', name: 'ip'},
            {data: 'created_at', name: 'created_at'},
        ],    
        searchDelay: 500,
    });



});

</script>

@endsection