@extends('admin_master')

@section('title','List of News')

@section('content')
    <div class="row box_containner">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="dash_boxcontainner white_boxlist">
                <div class="upper_basic_heading"><span class="white_dash_head_txt">
                         List of All News
                          <button onclick="add_news()" class="btn btn-default pull-right"><i
                                      class="mdi mdi-plus"></i>Add</button>
                      </span>
                    <table id="example" class="table table-bordered dataTable table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr class="bg-info">
                            <th class="hidden">Id</th>
                            <th class="options">Options</th>
                            <th>Text</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($news)>0)
                            @foreach($news as $new)
                                <tr>
                                    <td class="hidden">{{$new->id}}</td>
                                    <td id="{{$new->id}}">
                                        <a href="#" id="{{$new->id}}" onclick="edit_news(this)"
                                           class="btn btn-sm btn-default edit-user_"
                                           title="Edit News" data-toggle="tooltip" data-placement="top">
                                            <span class="fa fa-pencil"></span></a>
                                        <button type="button" onclick="inactive_news(this)"
                                                id="{{ $new->id }}"
                                                class="btn btn-sm btn-danger btnDelete"
                                                title="Delete News" data-toggle="tooltip"
                                                data-placement="top"><span
                                                    class="fa fa-trash-o" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                    <td>{{$new->text}}</td>
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
        function inactive_news(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/images/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Deletion');
            $('#mybody').html('<h5>Are you sure want to delete this News<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-danger" href="{{ url('news') }}/' + id +
                '/delete"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }

        function edit_news(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit News');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/news/" + id + "/edit";
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


        function add_news() {
            $('#myModal').modal('show');
            $('#modal_title').html('Add New News');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "{{ url('news/create') }}",
                success: function (data) {
                    $('#mybody').html(data);
                },
                error: function (xhr, status, error) {
                    $('#mybody').html(xhr.responseText);
                }
            });
        }

    </script>
@stop
