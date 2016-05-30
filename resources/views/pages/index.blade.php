<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <base href="/">

    <title>RCS Discord Bot</title>

    {!! Html::style(elixir('css/app.css')) !!}
    <script>
        window.baseUrl = '{{ url('/') }}';
    </script>
</head>
<body>
    <div id="main-app"></div>

    {!! Html::script('js/common.js') !!}
    {!! Html::script('js/app.js') !!}
</body>

</html>
