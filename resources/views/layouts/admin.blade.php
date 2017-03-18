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
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/all.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/r-2.1.0/datatables.min.css"/>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">

        <header style="padding:0px;">
            <div class="wrap">
                <div class="logo-menu">
                    <div class="logo"><a href="http://www.teleportoo.cz"><img src="{{ URL::asset('public/images/teleportoo-logo.jpg') }}" style="width:150px !important;margin-top: 10px;margin-bottom: 10px;"/></a></div>
                    <div class="menu">
                        <ul>
                             <li><a href="/logout" title="Logout">Logout</a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>



            <ul class="nav nav-tabs">
              <li role="presentation" {{ Request::is('admin/customer-list') ? ' class=active' : null }}><a href="{{ url('/admin/customer-list') }}">Customers List</a></li>
              <li role="presentation" {{ Request::is('admin/movers-list') ? ' class=active' : null }}><a href="{{ url('/admin/movers-list') }}">Movers List</a></li>
              <li role="presentation" {{ Request::is('admin/orders-list') ? ' class=active' : null }}><a href="{{ url('/admin/orders-list') }}">Orders List</a></li>
              <li role="presentation" {{ Request::is('admin/payments') ? ' class=active' : null }}><a href="{{ url('/admin/payments') }}">Payment Add Credit Mover</a></li>
              <li role="presentation" {{ Request::is('admin/settings') ? ' class=active' : null }}><a href="{{ url('/admin/settings') }}">Manage Settings</a></li>
            </ul>



        </header>

        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
        <script type="text/javascript" src="{{ URL::asset('public/js/app.js') }}"></script>
       <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
       <script type="text/javascript" src="{{ URL::asset('public/js/admin.js') }}"></script>
       <script type="text/javascript" src="{{ URL::asset('public/js/admin.dev.js') }}"></script>
</body>
</html>
