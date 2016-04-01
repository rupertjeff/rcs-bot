@extends('layouts.full')

@section('pageTitle')RCS Discord Bot Admin @endsection

@section('body')
    <section class="row">
        <div class="col-xs-12">
            <div id="command-listing"></div>
        </div>
    </section>
@endsection

@section('headJS')
    {!! Html::script(elixir('js/libraries.js')) !!}
    {!! Html::script(elixir('js/app.js')) !!}
@endsection
