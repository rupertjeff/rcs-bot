@extends('layouts.default')

@section('content')
    <h1>Discord Demos</h1>

    @if (session()->has('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    @include('partials.demos.customMessage')
    @include('partials.demos.delayedMessage')
    @include('partials.demos.channelMessage')
@endsection
