@extends('layouts.default')

@section('content')
    <header>
        <nav class="navbar navbar-fixed-top bg-inverse">
            <h1 class="navbar-brand">RCS Discord Bot</h1>
        </nav>
    </header>
    <div class="container-fluid" style="padding-top: 3.375rem">
        @yield('body')
    </div>
    <footer>
        <div class="container">
            <p>Built by {!! link_to('https://twitter.com/jeffrupertmusic', 'Vexillarius') !!}</p>
        </div>
    </footer>
@endsection
