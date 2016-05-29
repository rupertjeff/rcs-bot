<!doctype html>
<html ng-app="botAdmin">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <base href="/">

    <title>@yield('pageTitle', 'Bot')</title>

    {!! Html::style(elixir('css/app.css')) !!}
    @yield('headJS')
</head>
<body>
    @yield('content')

    @yield('JS')
</body>

</html>
