{!! Form::open($formSetup) !!}

<h2>Basic Post Message</h2>

<div class="form-group">
    <div class="input-group">
        {!! Form::text('message', '', ['class' => 'form-control', 'placeholder' => 'Type your message here, like Discord!']) !!}
        <div class="input-group-btn">
            {!! Form::button('Send', ['type' => 'submit', 'class' => 'btn btn-success', 'id' => 'submit-custom-message']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}
