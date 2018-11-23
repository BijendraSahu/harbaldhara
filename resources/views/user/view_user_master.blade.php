@extends('admin_master')

@section('title','List of Users')

@section('content')
    {{--@if(session()->has('message'))--}}
    {{--<div class="alert alert-success">--}}
    {{--{{ session()->get('message') }}--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--@if($errors->any())--}}
    {{--<div role='alert' id='alert' class='alert alert-danger'>{{$errors->first()}}</div>--}}
    {{--@endif--}}
    <style type="text/css">
        .grid-dropdown {
            min-width: 90px !important;
            max-width: 100px !important;
            z-index: 10;
        }

        .grid-dropdown > li > a {
            padding: 4px 5px;
            border-bottom: solid thin #e1e1e1;
            cursor: pointer;
            text-align: left !important;
        }

        .optiondrop_icon {
            margin-right: 4px;
            font-size: 12px;
            color: #186fb9;
        }
    </style>
    <div class="row box_containner">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="dash_boxcontainner white_boxlist">
                <div class="upper_basic_heading"><span class="white_dash_head_txt">
                         List of All Users
                         <button class="btn btn-default pull-right btn-sm" onclick="exporttoexcel();"><i
                                     class="mdi mdi-download"></i> Download Excel</button>
                      </span>
                    <table id="example" class="table table-bordered dataTable table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr class="bg-info">
                            <th class="hidden">Id</th>
                            <th class="options export_hide">Action</th>
                            {{--<th>Profile</th>--}}
                            <th>Referral Code</th>
                            <th>Name</th>
                            {{--<th>Contact</th>--}}
                            <th>Paytm No</th>
                            <th>City</th>
                            <th>Points</th>
                            <th>Payable Amt(Rs.)</th>
                            <th>Reffer By</th>
                            <th>Active Status</th>
                            <th>Joining Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($user_masters)>0)
                            @foreach($user_masters as $user_master)
                                @php
                                    $user = DB::selectOne("SELECT * FROM users where id in (select reffer_by from reffer where reffer_to = $user_master->id)");
                                    $user_bank = \App\UserBankDetails::where(['user_id'=>$user_master->id])->first();
                                 $admin = \App\AdminModel::find(1);
                                 $rupees = $user_master->points/$admin->point_to_rupee;
                                @endphp
                                @if(isset($user_bank->aadhar_pan))
                                    @php $pay_amt = $rupees-$rupees*10/100;
                                    $tds_percent = 10;
                                    @endphp
                                @else
                                    @php $pay_amt = $rupees-$rupees*20/100;
                                    $tds_percent = 20;
                                    @endphp
                                @endif
                                <tr>
                                    <td class="hidden">{{$user_master->id}}</td>
                                    <td class="export_hide" id="{{$user_master->id}}">
                                        <div class="btn-group position_absolute ">
                                            {{--<button type="button" class="btn btn-primary btn-xs action-btn"--}}
                                            {{--data-toggle="dropdown" aria-haspopup="true"--}}
                                            {{--aria-expanded="false">Options--}}
                                            {{--</button>--}}
                                            <button type="button" class="btn btn-primary btn-xs action-btn"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="true">Action <span class="caret"></span><span
                                                        class="sr-only">Toggle Dropdown</span></button>
                                            <ul class="dropdown-menu dropdown-menu-right grid-dropdown">
                                                {{--<li><a data-toggle="modal"--}}
                                                {{--data-target="#Modal_ViewDetails_LatestNews"><i--}}
                                                {{--class="mdi mdi-more optiondrop_icon"></i>More</a>--}}
                                                {{--</li>--}}
                                                <li><a href="#" id="{{$user_master->id}}" onclick="edit_user(this)"
                                                       class="btn btn-xs edit-user_"
                                                       title="Edit User" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-pencil optiondrop_icon"></i> Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#" id="{{$user_master->id}}" onclick="remind_user(this)"
                                                       class="btn btn-sm"
                                                       title="Remind user for payment" data-toggle="tooltip"
                                                       data-placement="top">
                                                        <i class="mdi mdi-more optiondrop_icon"></i> Reminder</a>
                                                </li>
                                                <li>
                                                    @if($user_master->is_paid == 1)
                                                        <a href="#" id="{{$user_master->id}}"
                                                           onclick="inactive_user(this)"
                                                           class="btn btn-sm"
                                                           title="Mark as unpaid/inactive" data-toggle="tooltip"
                                                           data-placement="top">
                                                            <i class="mdi mdi-delete optiondrop_icon"></i>
                                                            Unpaid/Inactive</a>
                                                    @else
                                                        <a href="#" id="{{$user_master->id}}"
                                                           onclick="active_user(this)"
                                                           class="btn btn-sm"
                                                           title="Mark as paid/active" data-toggle="tooltip"
                                                           data-placement="top">
                                                            <i class="mdi mdi-check optiondrop_icon"></i>
                                                            Paid/Active</a>

                                                    @endif
                                                </li>
                                                <li>
                                                    <a href="#" id="{{$user_master->id}}"
                                                       onclick="repurchase_user(this)"
                                                       class="btn btn-sm"
                                                       title="Send Repurchase Point" data-toggle="tooltip"
                                                       data-placement="top">
                                                        <span class="mdi mdi-repeat"></span> Repurchase</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    {{--<td>--}}
                                    {{--<div class="post_imgblock_admin"><img style="height: 100%; width: 100%"--}}
                                    {{--src="{{url('').'/'.$user_master->profile_img}}"/>--}}
                                    {{--</div>--}}
                                    {{--</td>--}}
                                    <td>{{$user_master->rc}}</td>
                                    <td>{{$user_master->name}}</td>
                                    {{--<td>{{$user_master->contact}}</td>--}}
                                    <td>{{$user_master->paytm_contact}}</td>
                                    <td>{{isset($user_master->city)?$user_master->city:'-'}}</td>
                                    <td>{{$user_master->points}}</td>
                                    <td>@if($pay_amt>0){{$pay_amt}} <span class="badge">-{{$tds_percent}}
                                            %</span>@else {{0}} @endif</td>
                                    <td>
                                        @if(isset($user))
                                            {{$user->name}} <br> {{$user->rc}}
                                        @else
                                            {{"-"}}
                                        @endif
                                    </td>

                                    <td>
                                        @if($user_master->is_paid == 1)
                                            <p class="bg-success">Paid</p>
                                        @else
                                            <p class="bg-danger">Unpaid</p>

                                        @endif
                                    </td>
                                    <td> {{ date_format(date_create($user_master->created_time), "d-M-Y h:i A")}}</td>
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
        function inactive_user(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/img/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Inactivation');
            $('#mybody').html('<h5>Are you sure want to Inactivate/unpaid this user<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-danger" href="{{ url('user_master') }}/' + id +
                '/inactivate"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }

        function empty_user(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/img/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Inactivation');
            $('#mybody').html('<h5>Are you sure want to empty points for this user<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-danger" href="{{ url('user_master') }}/' + id +
                '/empty"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }

        function remind_user(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/img/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Inactivation');
            $('#mybody').html('<h5>Are you sure want to remind this user for payment<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-success" href="{{ url('user_master') }}/' + id +
                '/remind"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }
        function repurchase_user(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/img/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Inactivation');
            $('#mybody').html('<h5>Are you sure want to mark repurchase for this user<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-success" href="{{ url('user_master') }}/' + id +
                '/repurchase"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }

        function active_user(dis) {
            {{--var id = $(dis).attr('id');--}}
            {{--$('#myModal').modal('show');--}}
            {{--$('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/img/loading.gif') }}"/>');--}}
            {{--$('#modal_title').html('Confirm Activation');--}}
            {{--$('#mybody').html('<h5>Are you sure want to activate/paid this user<h5/>');--}}
            {{--$('#modalBtn').removeClass('hidden');--}}
            {{--$('#modalBtn').html('<a class="btn btn-sm btn-success" href="{{ url('user_master') }}/' + id +--}}
                {{--'/activate"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'--}}
            {{--);--}}
            $('#myModal').modal('show');
            $('#modal_title').html('Activate User');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/img/loading.gif')}}"/>');

            var id = $(dis).attr('id');
            var editurl = '{{ url('activate_with_key').'/' }}' + id;
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
        function edit_user(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit User');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/user_master/" + id + "/edit";
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
