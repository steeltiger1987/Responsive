<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/map.css') }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script>
        var userId = {{ Auth::user()->id }};
    </script>
</head>
<body>
    <div id="app">
        @include('elements.header')

        @yield('content')
    </div>

    <!-- Scripts -->
        <script type="text/javascript" src="{{ URL::asset('public/js/app.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('public/js/all.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('public/js/map.js') }}"></script>
        <script>
            $("#country_selector").countrySelect({
                //defaultCountry: "jp",
                //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                preferredCountries: ['gb', 'ca', 'us']
            });
        </script>
</body>
</html>
