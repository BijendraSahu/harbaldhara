@extends('admin_master')

@section('title', 'Amount Distribution')

@section('head')
    <style>

        .btn_center {
            text-align: center;
            margin-top: 10px;
        }

        .update_btn {
            display: none;
        }

        .hidealways {
            display: none;
        }

        .label_checkbox {
            display: inline-block;
        }

        .label_checkbox .cr {
            margin: 0px 5px;
        }

        .newrow {
            background: #1e81cd52 !important;
        }

        .border_none {
            border: none !important;
        }

    </style>
@stop
@section('content')
    <section class="box_containner">
        <div class="container-fluid">
            <div class="row">

                <section id="menu2">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="dash_boxcontainner white_boxlist">
                            <div class="upper_basic_heading"><span class="white_dash_head_txt">
                       Amount Distribution Report
                                    {{--<button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();"><i--}}
                                    {{--class="mdi mdi-download"></i> Download Excel</button>--}}

                    </span>
                                <section id="user_table" class="table_main_containner">
                                    <form action="{{url('distribution')}}" method="post"
                                          enctype="multipart/form-data">
                                        <div class="col-sm-12">

                                            <div class="col-sm-4">
                                                <label for="">Start End</label>
                                                <input type="text" placeholder="Start Date"
                                                       data-format="dd/MM/yyyy hh:mm:ss" autocomplete="off"
                                                       class="form-control dtp"
                                                       name="start_date"/>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="">End Date</label>
                                                <input type="text" placeholder="End Date" class="form-control dtp"
                                                       autocomplete="off" name="end_date"/>
                                            </div>
                                            <br>
                                            <div class="col-sm-4">
                                                <span></span>
                                                <button class="btn btn-primary">Search</button>
                                                <a href="{{url('distribution')}}" class="btn btn-success">Refresh</a>
                                            </div>
                                        </div>
                                    </form>

                                        <div class="table-scroll style-scroll">
                                            <table id="example" class="table table-bordered dataTable table-striped" cellspacing="0"
                                                   width="100%">
                                                <thead>
                                                <tr class="bg-info">
                                                    <th class="hidden">Id</th>
                                                    <th>Name</th>
                                                    <th>Contact</th>
                                                    <th>Paytm Contact</th>
                                                    <th>Points Request</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Reject Reason</th>
                                                    <th>Approval Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($redeem_requests)>0)
                                                    @foreach($redeem_requests as $redeem_request)
                                                        <tr>
                                                            <td class="hidden">{{$redeem_request->id}}</td>

                                                            <td>{{isset($redeem_request->user->name)?$redeem_request->user->name:"-"}}</td>
                                                            <td>{{isset($redeem_request->user->contact)?$redeem_request->user->contact:''}}</td>
                                                            <td>{{isset($redeem_request->user->paytm_contact)?$redeem_request->user->paytm_contact:''}}</td>
                                                            <td>{{$redeem_request->point}}</td>
                                                            <td>{{"Rs. ".$redeem_request->amount}}</td>
                                                            <td>@if($redeem_request->status == 'approved')
                                                                    <label class="label label-success">Approved</label>
                                                                @elseif($redeem_request->status == 'pending')
                                                                    <label class="label label-warning">Pending</label>
                                                                @else
                                                                    <label class="label label-danger"
                                                                           title="{{$redeem_request->reject_reason}}"
                                                                           data-toggle="tooltip" data-placement="top">Rejected</label>
                                                                @endif
                                                            </td>
                                                            <td>{{isset($redeem_request->reject_reason)?$redeem_request->reject_reason:'-'}}</td>
                                                            <td> {{ isset($redeem_request->approved_time)?date_format(date_create($redeem_request->approved_time), "d-M-Y h:i A"):'-'}}</td>

                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                </section>
                            </div>


                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <script>

        // $('.btnDelete').click(function () {
        {{--var id = $(this).attr('id');--}}
        {{--var append_url = '{{ url('loaded_items') }}/' + id + "/delete";--}}
        {{--$('#ConfirmBtn').attr("href", append_url);--}}
        // $("#loaded_frm").submit();
        // });

        {{--$(document).ready(function () {--}}
        {{--// globalloadershow();--}}
        {{--$("#userpostForm").on('submit', function (e) {--}}
        {{--e.preventDefault();--}}
        {{--swal({--}}
        {{--title: "Are you sure?",--}}
        {{--text: "You want to delete selected items...!",--}}
        {{--icon: "warning",--}}
        {{--buttons: true,--}}
        {{--dangerMode: true,--}}
        {{--}).then((okk) => {--}}
        {{--if (okk) {--}}
        {{--$.ajax({--}}
        {{--type: 'POST',--}}
        {{--url: "{{ url('loaded_items_delete') }}",--}}
        {{--data: new FormData(this),--}}
        {{--contentType: false,--}}
        {{--cache: false,--}}
        {{--processData: false,--}}
        {{--// beforeSend: function () {--}}
        {{--//     $('#userpostForm').css("opacity", ".5");--}}
        {{--//     $(".btn_post").attr("disabled");--}}
        {{--// },--}}
        {{--success: function (data) {--}}
        {{--// HideOnpageLoopader1();--}}
        {{--swal("Success!", "Your post has been uploaded...", "success");--}}
        {{--// ShowSuccessPopupMsg('Your post has been uploaded...');--}}
        {{--// $('#image_preview').text('');--}}
        {{--// $('.emojionearea-editor').empty();--}}
        {{--// $('#post_text_emoji').text('');--}}
        {{--// $('#posttext').val('');--}}
        {{--// $('#upload_file_image').val('');--}}
        {{--// $('#upload_file_video').val('');--}}
        {{--// $('#userpostForm').css("opacity", "");--}}
        {{--// $(".btn_post").removeAttr("disabled");--}}
        {{--// latest_dashboardpostload();--}}
        {{--},--}}
        {{--error: function (xhr, status, error) {--}}
        {{--ShowErrorPopupMsg('Error in uploading...');--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
        {{--});--}}

        {{--});--}}
        {{--});--}}

        function searchTable() {
            var input, filter, found, table, tr, td, i, j;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                    found = false;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        function edit_loaded(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit Loaded Items');
            $('#modal_body').html('<img height="50px" class="center-block" src="{{url('images/loading.gif')}}"/>');

            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/edit_loaded/" + id;
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: editurl,
                // data: '{"data":"' + id + '"}',
                data: {id: id},
                success: function (data) {
                    $('#modal_body').html(data);
                },
                error: function (xhr, status, error) {
                    $('#modal_body').html(xhr.responseText);
                    //$('#modal_body').html("Technical Error Occured!");
                }
            });
        }
    </script>

@stop