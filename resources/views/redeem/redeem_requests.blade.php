@extends('admin_master')

@section('title','List of Redeem Requests')

@section('content')
    <style>
        .ads_img {
            height: 200px;
            width: 200px;
        }
    </style>
    {{--@if(session()->has('message'))--}}
    {{--<div class="alert alert-success">--}}
    {{--{{ session()->get('message') }}--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--@if($errors->any())--}}
    {{--<div role='alert' id='alert' class='alert alert-danger'>{{$errors->first()}}</div>--}}
    {{--@endif--}}
    <div class="row box_containner">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="dash_boxcontainner white_boxlist">
                <div class="upper_basic_heading"><span class="white_dash_head_txt">
                         List of Redeem Requests
                           <button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();"><i
                                       class="mdi mdi-download"></i> Download Excel</button>
                      </span>
                    <table id="example" class="table table-bordered dataTable table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr class="bg-info">
                            <th class="hidden">Id</th>
                            <th class="options export_hide">Options</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Paytm Contact</th>
                            <th>Points Request</th>
                            <th>Amount(Rs)</th>
                            <th>Payable Amt(Rs)</th>
                            <th>Status</th>
                            <th>Approve/Reject Reason</th>
                            <th>Approval Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $Total_Payable_Amt = 0;
                            $Total_Paid_Amt = 0;
                        @endphp
                        @if(count($redeem_requests)>0)
                            @foreach($redeem_requests as $redeem_request)
                                @php
                                    $user_bank = \App\UserBankDetails::where(['user_id'=>$redeem_request->user_id])->first();
                                @endphp
                                @if(isset($user_bank->aadhar_pan))
                                    @php $pay_amt = $redeem_request->amount-$redeem_request->amount*10/100;
                                    $tds_percent = 10;
                                    @endphp
                                @else
                                    @php $pay_amt = $redeem_request->amount-$redeem_request->amount*20/100;
                                    $tds_percent = 20;
                                    @endphp
                                @endif
                                <tr>
                                    <td class="hidden">{{$redeem_request->id}}</td>
                                    <td class="export_hide" id="{{$redeem_request->id}}">
                                        @if($redeem_request->status == 'pending')
                                            <button type="button" onclick="reject(this)"
                                                    id="{{ $redeem_request->id }}"
                                                    class="btn btn-sm btn-danger btnDelete"
                                                    title="Reject Request" data-toggle="tooltip"
                                                    data-placement="top"><span
                                                        class="fa fa-trash-o" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" onclick="approved(this)"
                                                    id="{{ $redeem_request->id }}"
                                                    class="btn btn-sm btn-success btnActive"
                                                    title="Approve Request" data-toggle="tooltip"
                                                    data-placement="top"><span
                                                        class="fa fa-check"
                                                        aria-hidden="true"></span></button>

                                        @else
                                            {{'N/A'}}
                                        @endif
                                    </td>
                                    <td>{{isset($redeem_request->user->name)?$redeem_request->user->name:"-"}}</td>
                                    <td>{{isset($redeem_request->user->contact)?$redeem_request->user->contact:''}}</td>
                                    <td>{{isset($redeem_request->user->paytm_contact)?$redeem_request->user->paytm_contact:''}}</td>
                                    <td>{{$redeem_request->point}}</td>
                                    <td>{{$redeem_request->amount}}</td>
                                    <td>{{$pay_amt}} <span class="badge">-{{$tds_percent}}%</span>
                                    </td>
                                    <td>@if($redeem_request->status == 'approved')
                                            <label class="label label-success">Approved</label>
                                            @php  $Total_Paid_Amt += $pay_amt @endphp
                                        @elseif($redeem_request->status == 'pending')
                                            <label class="label label-warning">Pending</label>
                                            @php  $Total_Payable_Amt += $pay_amt @endphp
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
                    <span>Total Paid Amount : {{$Total_Paid_Amt}}</span><br>
                    <span>Total Payable Amount : {{$Total_Payable_Amt}}</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        {{--function approved(dis) {--}}
            {{--var id = $(dis).attr('id');--}}
            {{--$('#myModal').modal('show');--}}
            {{--$('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/images/loading.gif') }}"/>');--}}
            {{--$('#modal_title').html('Confirm Inactivation');--}}
            {{--$('#mybody').html('<h5>Are you sure want to accept this request<h5/>');--}}
            {{--$('#modalBtn').removeClass('hidden');--}}
            {{--$('#modalBtn').html('<a class="btn btn-sm btn-success" href="{{ url('redeem_request') }}/' + id +--}}
                {{--'/approve"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'--}}
            {{--);--}}
        {{--}--}}
        function approved(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Approval Redeem Request');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/redeem_request/" + id + "/approve";
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: editurl,
                data: '{"data":"' + id + '"}',
                success: function (data) {
                    $('#mybody').html(data);
                },
                error: function (xhr, status, error) {
                    $('#mybody').html(xhr.responseText);
                    //$('.modal-body').html("Technical Error Occured!");
                }
            });
        }
        function reject(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Reject Redeem Request');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/redeem_request/" + id + "/reject";
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: editurl,
                data: '{"data":"' + id + '"}',
                success: function (data) {
                    $('#mybody').html(data);
                },
                error: function (xhr, status, error) {
                    $('#mybody').html(xhr.responseText);
                    //$('.modal-body').html("Technical Error Occured!");
                }
            });
        }
    </script>
@stop
