<script src="{{ url('assets/js/validation.js') }}"></script>
{!! Form::open(['url' => 'redeem_request/'.$redeem_requests->id.'/approve', 'class' => 'form-horizontal', 'id'=>'user_master']) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class='form-group'>
            {!! Form::label('', '', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <p></p>
                <label for="" class="badge">Are you sure want to approved this request</label>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('role', 'Enter Approval Reason *', ['class' => 'col-sm-2 control-label']) !!}
            <div class='col-sm-8'>
                <textarea class="form-control required" row="5" column="5" placeholder="Enter Approval Reason"
                          name="approve_reason"></textarea>
            </div>
        </div>
        <div class='form-group'>
            <div class='col-sm-offset-2 col-sm-8'>
                {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
