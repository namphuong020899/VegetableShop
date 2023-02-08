@extends('Layout_admin')
@section('content')
    @include('BackEnd.sample')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active clicklist" data-toggle="tab" href="#list" role="tab">
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down">List</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link editclick" data-toggle="tab" href="#sample" role="tab">
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down sampleTitel">Add</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" id="list" role="tabpanel">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="sample_load" class="table table-striped table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Code</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane  p-20" id="sample" role="tabpanel">
                            <form id="submit_form" action="post">
                                <input type="hidden" id="hidden_cate_id">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" required class="form-control" name="coupon_code"
                                            id="coupon_code" placeholder="Enter Code">
                                    </div>
                                    <div class="form-group">
                                        <label>Qty</label>
                                        <input type="text" required data-parsley-pattern="^[1-9]\d{0,7}(?:\.\d{1,4})?$"
                                            data-parsley-trigger="keyup" class="form-control" name="coupon_qty"
                                            id="coupon_qty" placeholder="Enter Qty">
                                    </div>
                                    <div class="form-group">
                                        <label>Condition</label>
                                        <select required class="form-control" id="coupon_condition"
                                            name="coupon_condition">
                                            <option value="1">Money</option>
                                            <option value="2">Percent</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Number</label>
                                        <div class="input-group">
                                            <input type="text" required
                                                data-parsley-pattern="^[1-9]\d{0,7}(?:\.\d{1,4})?$"
                                                data-parsley-trigger="keyup" class="form-control"
                                                name="coupon_sale_number" id="coupon_sale_number"
                                                placeholder="Enter Number">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                                <span class="input-group-text none" id="basic-addon3">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-t-20">
                                        <label>Date Start <small class="text-muted">yyyy/mm/dd</small></label>
                                        <input type="text" required class="form-control date-inputmask"
                                            id="coupon_date_start" name="coupon_date_start" placeholder="Enter Start"
                                            value="{{ Carbon\Carbon::now()->format('Y/m/d') }}">
                                    </div>
                                    <div class="form-group m-t-20">
                                        <label>Date End <small class="text-muted">yyyy/mm/dd</small></label>
                                        <input type="text" required class="form-control date-inputmask" id="coupon_date_end"
                                            name="coupon_date_end" placeholder="Enter End"
                                            value="{{ Carbon\Carbon::tomorrow()->format('Y/m/d') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select required class="form-control" id="coupon_status" name="coupon_status">
                                            <option value="1">Show</option>
                                            <option value="2">Hide</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <input type="hidden" id="hidden_action" value="Add">
                                        <button type="submit" class="btn btn-primary submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .none{
            display: none;
        }
    </style>
@endsection

@section('css')
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection
@section('js')
    <script src="{{ asset('backend/assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/dist/js/pages/mask/mask.init.js') }}"></script>
    <script src="{{ asset('backend/assets/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('backend/assets/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('backend/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <script>
        // Check
        $('#submit_form').parsley();
        $(document).ready(function() {
            var today   = new Date();
            var dd      = today.getDate();
            var mm      = today.getMonth()+1;
            var yyyy    = today.getFullYear();

            $('#coupon_condition').click(function(){
                var value = $(this).val();
                if(value == 1){
                    $('#basic-addon2').removeClass('none');
                    $('#basic-addon3').addClass('none');
                }else{
                    $('#basic-addon3').removeClass('none');
                    $('#basic-addon2').addClass('none');
                }
            });
            // Load Table
            $('#sample_load').DataTable({
                destroy: true,
                order:[],
                ajax: {
                    url: "{{ route('coupon.index') }}",
                },
                columns: [{
                        data: 'coupon_code'
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            if (data.coupon_status == 1) {
                                $output =
                                    '<button type="button" class="btn btn-success btn-sm click_status" data-id="' +
                                    data.coupon_id + '">Show</button>';
                            } else {
                                $output =
                                    '<button type="button" class="btn btn-danger btn-sm click_status" data-id="' +
                                    data.coupon_id + '">Hide</button>';
                            }
                            return $output;
                        },
                        orderable: false
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            var date_end = new Date(data.coupon_date_end);
                            var date_end_dd = date_end.getDate();
                            var date_end_mm = date_end.getMonth() + 1;
                            var date_end_yyyy = date_end.getFullYear();

                            if (mm < date_end_mm && date_end_yyyy >= yyyy) {
                                $output =
                                    '<button type="button" class="btn btn-success btn-sm">Expiry Date</button>';
                            } else if (mm == date_end_mm && date_end_yyyy == yyyy) {
                                if (date_end_dd >= dd) {
                                    $output =
                                        '<button type="button" class="btn btn-success btn-sm">Expiry Date</button>';
                                } else {
                                    $output =
                                        '<button type="button" class="btn btn-danger btn-sm">Out Of Date</>';
                                }
                            } else {
                                $output =
                                    '<button type="button" class="btn btn-danger btn-sm">Out Of Date</button>';
                            }
                            return $output;
                        },
                        orderable: false
                    },
                    {
                        data: 'action'
                    }
                ]
            });
            // Reset Form
            $('.clicklist').click(function() {
                $('#hidden_action').val('Add');
                $('.sampleTitel').text('Add')

                $('#submit_form')[0].reset();
                $('#submit_form').parsley().reset();
            });
            // Add & Update
            $(document).on('submit', '#submit_form', function(e) {
                e.preventDefault();
                if ($('#submit_form').parsley().isValid()) {
                    var action_url = '';
                    var action_type = '';
                    var coupon_code = $('#coupon_code').val();
                    var coupon_qty = $('#coupon_qty').val();
                    var coupon_condition = $('#coupon_condition').val();
                    var coupon_sale_number = $('#coupon_sale_number').val();
                    var coupon_date_start = $('#coupon_date_start').val();
                    var coupon_date_end = $('#coupon_date_end').val();
                    var coupon_status = $('#coupon_status').val();

                    if ($('#hidden_action').val() == 'Add') {
                        action_url = '{{ route('coupon.store') }}';
                        action_type = 'POST';
                    } else {
                        var id = $('#hidden_cate_id').val();
                        action_url = 'coupon/' + id;
                        action_type = "PUT";
                    }

                    $.ajax({
                        type: action_type,
                        url: action_url,
                        data: {
                            coupon_code: coupon_code,
                            coupon_qty: coupon_qty,
                            coupon_condition: coupon_condition,
                            coupon_sale_number: coupon_sale_number,
                            coupon_date_start: coupon_date_start,
                            coupon_date_end: coupon_date_end,
                            coupon_status: coupon_status,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            $('.submit').attr('disabled', 'disabled');
                            $('.submit').val('Submitting...');
                        },
                        success: function(res) {
                            if (res.status == 200) {
                                $('#submit_form')[0].reset();
                                $('#submit_form').parsley().reset();
                                $('.submit').attr('disabled', false);
                                $('#sample_load').DataTable().ajax.reload();
                                if ($('#hidden_action').val() == 'Edit') {
                                    $('.clicklist').addClass('active show');
                                    $('.editclick').removeClass('active show');
                                    $('#list').addClass('active show');
                                    $('#sample').removeClass('active show');
                                    $('#hidden_action').val('Add');
                                    $('.sampleTitel').text('Add')
                                }
                            } else {
                                alert(res.message);
                            }
                        }
                    });
                }
            });
            //Edit
            $(document).on('click', '.editsample', function(e) {
                var id = $(this).data('id');
                $('.clicklist').removeClass('active show');
                $('.editclick').addClass('active show');
                $('#list').removeClass('active show');
                $('#sample').addClass('active show');

                $.ajax({
                    type: 'get',
                    url: 'coupon/' + id,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 200) {
                            $('#hidden_action').val('Edit');
                            $('.sampleTitel').text('Edit "' + res.data.coupon_code + '"');
                            $('#hidden_cate_id').val(id);
                            $('#coupon_code').val(res.data.coupon_code);
                            $('#coupon_qty').val(res.data.coupon_qty);
                            $('#coupon_date_start').val(res.data.coupon_date_start);
                            $('#coupon_date_end').val(res.data.coupon_date_end);
                            $('#coupon_condition').val(res.data.coupon_condition);
                            $('#coupon_sale_number').val(res.data.coupon_sale_number);
                            $('#coupon_status').val(res.data.coupon_status);
                        } else {
                            alert(res.message)
                        }
                    }
                });
            });
            // Delete
            $(document).on('click', '.delete', function() {
                var id = $(this).data('id');
                var result = confirm("Want to delete?");
                if (result) {
                    $.ajax({
                        type: 'delete',
                        url: 'coupon/' + id,
                        success: function(res) {
                            if (res.status == 200) {
                                $('#sample_load').DataTable().ajax.reload();
                                alert(res.message);
                            } else {
                                alert(res.message);
                            }

                        }
                    });
                }
            });
            // Status
            $(document).on('click', '.click_status', function() {
                var id = $(this).data('id');

                $.ajax({
                    type: 'get',
                    url: 'coupon/' + id + '/edit',
                    success: function(res) {
                        if (res.status == 200) {
                            $('#sample_load').DataTable().ajax.reload();
                        } else {
                            alert(res.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
