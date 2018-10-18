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
                      </span>
                    <table id="example" class="table table-bordered dataTable table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr class="bg-info">
                            <th class="hidden">Id</th>
                            <th class="options">Options</th>
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
                                    <td id="{{$redeem_request->id}}">
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
            </div>
        </div>
    </div>
    <br/>
    <script>
        function approved(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/images/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Inactivation');
            $('#mybody').html('<h5>Are you sure want to accept this request<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-success" href="{{ url('redeem_request') }}/' + id +
                '/approve"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
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
