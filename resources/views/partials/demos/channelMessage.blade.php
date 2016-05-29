{!! Form::open($formSetup) !!}

<h2>Channel Message</h2>

<div class="form-group">
    {!! Form::label('channel-message', 'Message:', ['class' => 'sr-only']) !!}
    {!! Form::text('channel-message', '', ['class' => 'form-control', 'placeholder' => 'Send this message to a channel!']) !!}
</div>

<div class="form-group">
    {!! Form::label('channel-name', 'Channel:', ['class' => 'sr-only']) !!}
    {!! Form::select('channel-name', $channels, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::button('Send to Channel', ['class' => 'btn btn-success', 'id' => 'submit-channel-message', 'type' => 'submit']) !!}
</div>

{!! Form::close() !!}
