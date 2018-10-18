@extends('admin_master')

@section('title','List of Gallery')

@section('content')
    <style>
        .ads_img {
            height: 100px;
            width: 100px;
        }
    </style>
    <div class="row box_containner">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="dash_boxcontainner white_boxlist">
                <div class="upper_basic_heading"><span class="white_dash_head_txt">
                         List of All Gallery
                          <button onclick="add_gallery()" class="btn btn-default pull-right"><i
                                      class="mdi mdi-plus"></i>Add</button>
                      </span>
                    <table id="example" class="table table-bordered dataTable table-striped" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr class="bg-info">
                            <th class="hidden">Id</th>
                            <th class="options">Options</th>
                            <th>Text</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($galleries)>0)
                            @foreach($galleries as $gallery)
                                <tr>
                                    <td class="hidden">{{$gallery->id}}</td>
                                    <td id="{{$gallery->id}}">
                                        <a href="#" id="{{$gallery->id}}" onclick="edit_gallery(this)"
                                           class="btn btn-sm btn-default edit-user_"
                                           title="Edit Gallery" data-toggle="tooltip" data-placement="top">
                                            <span class="fa fa-pencil"></span></a>
                                        <button type="button" onclick="inactive_gallery(this)"
                                                id="{{ $gallery->id }}"
                                                class="btn btn-sm btn-danger btnDelete"
                                                title="Delete Gallery" data-toggle="tooltip"
                                                data-placement="top"><span
                                                    class="fa fa-trash-o" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                    <td>{{$gallery->text}}</td>
                                    <td><img src="{{url('').'/'.$gallery->image}}" class="ads_img" alt="image">
                                    </td>
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
        function inactive_gallery(dis) {
            var id = $(dis).attr('id');
            $('#myModal').modal('show');
            $('#mybody').html('<img height="50px" class="center-block" src="{{ url('assets/images/loading.gif') }}"/>');
            $('#modal_title').html('Confirm Deletion');
            $('#mybody').html('<h5>Are you sure want to delete this gallery<h5/>');
            $('#modalBtn').removeClass('hidden');
            $('#modalBtn').html('<a class="btn btn-sm btn-danger" href="{{ url('gallery') }}/' + id +
                '/delete"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirm</a>'
            );
        }

        function edit_gallery(dis) {
            $('#myModal').modal('show');
            $('#modal_title').html('Edit Gallery');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            var id = $(dis).attr('id');
            var editurl = '{{ url('/') }}' + "/gallery_master/" + id + "/edit";
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


        function add_gallery() {
            $('#myModal').modal('show');
            $('#modal_title').html('Add New Gallery');
            $('#mybody').html('<img height="50px" class="center-block" src="{{url('assets/images/loading.gif')}}"/>');
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url: "{{ url('gallery_master/create') }}",
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
