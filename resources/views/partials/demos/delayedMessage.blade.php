{!! Form::open($formSetup) !!}

<h2>Delayed Message Send</h2>
<p>Each message is delayed based on when the previous message is sent! If two messages are sent on a 10s delay, the second message will show up after 20s.</p>

<div class="form-group">
    {!! Form::label('delayed-message', 'Message', ['class' => 'sr-only']) !!}
    {!! Form::text('delayed-message', '', ['class' => 'form-control', 'placeholder' => 'Type your message here.']) !!}
</div>

<div class="form-group">
    {!! Form::label('delayed-delay', 'Delay message by', ['class' => 'sr-only']) !!}
    {!! Form::select('delayed-delay', $delays, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group form-actions">
    {!! Form::button('Send on Delay', ['class' => 'btn btn-success', 'id' => 'submit-delayed-message', 'type' => 'submit']) !!}
</div>

{!! Form::close() !!}
