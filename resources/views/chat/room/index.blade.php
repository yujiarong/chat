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
                            <div class="row">
                                <div class="col-sm-6 table-toolbar-left">
                                    <h3 class="panel-title">聊天室管理</h3>
                                </div>
                                <div class="col-sm-6 table-toolbar-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#roomModal" >新增房间</button>
                                </div>
                            </div>

                        </div>
                        <div class="panel-body">
                            <table id="demo-dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th class="min-tablet">在线用户</th>
                                        <th class="min-tablet">Creat Time</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->
                </div>


        <!--Fix Bootstrap Modal-->
        <!--===================================================-->
        <div class="modal fade" id="roomModal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">新增房间</h4>
                    </div>

                    <!--Modal body-->
                    <div class="modal-body">
                 
                            <div  class="form-horizontal">
                                <div class="form-group"> 
                                    <label class="col-md-4 control-label" >房间名字</label>
                                    <div class="col-md-6"> 
                                    <input id="name" name="name" type="text" placeholder="房间名字" class="form-control input-md"> 
                                    </div>
                                </div>    
                               
                            </div>
                            
                    </div>
                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <button class="btn btn-primary" id="save">Save </button>
                    </div>
                </div>
            </div>
        </div>
        <!--===================================================-->
        <!--End Default Bootstrap Modal-->     
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
            url: '{{ route("chat.room.tableGet") }}',
            type: 'post'
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'online_num', name: 'online_num'},
            {data: 'created_at', name: 'created_at'},
        ],    
        searchDelay: 500,
    });

    $('#save').click(function(event) {
        var  name            = $('#name').val();
        if(name == '' ){
            notify('warning','请输入房间的名字');
            return ;
        }
        senddata       = {'name':name}
        $.ajax({
            type        : 'post',
            url         : '/chat/room/store',
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data        : senddata,
            // dataType    : 'json',
            success     : function(e){
                if(e.code  == 200){
                    notify('success','操作成功');
                    setTimeout("window.location.reload()",1000);
                }else{
                    notify('warning',e.msg);
                }
            },
            error    : function(e) {
                notify('danger','出错了！请联系管理人员');
            }
        });
    });


});

</script>

@endsection