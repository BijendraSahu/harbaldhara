<script src="{{ url('assets/js/validation.js') }}"></script>

{!! Form::open(['url' => 'key/'.$key->id, 'class' => 'form-horizontal', 'id'=>'user_master', 'method'=>'put', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class='form-group'>
            {!! Form::label('name', 'Key *', ['class' => 'col-sm-1 control-label']) !!}
            <div class='col-sm-8'>
                {!! Form::text('key', $user_master->name, ['class' => 'form-control input-sm required','placeholder'=>'Key']) !!}
            </div>
        </div>
        <div class='form-group'>
            <div class='col-sm-offset-1 col-sm-10'>
                {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}

