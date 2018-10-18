<script src="{{ url('assets/js/validation.js') }}"></script>
{!! Form::open(['url' => 'news/'.$news->id, 'class' => 'form-horizontal', 'id'=>'user_master', 'method'=>'put', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="container-fluid">
        <div class="col-sm-12">

            <div class="form-group">
                {!! Form::label('text', 'Text *', ['class' => 'col-sm-2 control-label']) !!}
                <div class='col-sm-10'>
                    {!! Form::text('text', $news->text, ['class' => 'form-control input-sm required', 'placeholder'=>'Enter Text']) !!}
                </div>
            </div>

            <div class='form-group'>
                <div class='col-sm-offset-2 col-sm-10'>
                    {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
