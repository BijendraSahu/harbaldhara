<script src="{{ url('assets/js/validation.js') }}"></script>

{!! Form::open(['url' => 'user_master/'.$user_master->id, 'class' => 'form-horizontal', 'id'=>'user_master', 'method'=>'put', 'files'=>true]) !!}
<div class="container-fluid">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('role', 'Sponser *', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::select('activated_by', $sponsers, $user_master->activated_by,['class' => 'form-control requiredDD']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('name', 'Name *', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('name', $user_master->name, ['class' => 'form-control input-sm required','placeholder'=>'Name']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('contact', 'Contact *', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('contact', $user_master->contact, ['class' => 'form-control input-sm contact required', 'placeholder'=>'Contact']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('contact', 'Paytm Contact *', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('paytm_contact', $user_master->paytm_contact, ['class' => 'form-control input-sm contact required', 'placeholder'=>'Paytm Contact']) !!}
                </div>
            </div>

            <div class='form-group'>
                {!! Form::label('contact', 'Address ', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('address', $user_master->address, ['class' => 'form-control input-sm', 'placeholder'=>'Address']) !!}
                </div>
            </div>


        </div>
        <div class="col-sm-6">

            <div class='form-group'>
                {!! Form::label('name', 'Account Holder ', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('account_holder', isset($bank->account_holder)?$bank->account_holder:null, ['class' => 'form-control input-sm ','placeholder'=>'Account Holder']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('contact', 'Account Number ', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('ac_number', isset($bank->ac_number)?$bank->ac_number:null, ['class' => 'form-control input-sm', 'placeholder'=>'Contact']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('contact', 'Bank', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('bank', isset($bank->bank)?$bank->bank:null, ['class' => 'form-control input-sm', 'placeholder'=>'Bank']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('contact', 'IFSC Code', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('ifsc_code', isset($bank->ifsc_code)?$bank->ifsc_code:null, ['class' => 'form-control input-sm', 'placeholder'=>'IFSC Code']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('aadhar_pan', 'PAN', ['class' => 'col-sm-3 control-label']) !!}
                <div class='col-sm-9'>
                    {!! Form::text('aadhar_pan',isset($bank->aadhar_pan)?$bank->aadhar_pan:null, ['class' => 'form-control input-sm', 'placeholder'=>'PAN']) !!}
                </div>
            </div>


            <div class='form-group'>
                <div class='col-sm-offset-3 col-sm-9'>
                    {!! Form::submit('Submit', ['class' => 'btn btn-sm btn-primary']) !!}
                </div>
            </div>
        </div>
    </div>

</div>
{!! Form::close() !!}
