@extends('layouts.app')

@section('content')
    <section class="content">
            <a href="{{ url('/orders/show') }}">@lang('account.your_orders')</a>
            <a href="{{ url('/account/details') }}">@lang('account.personal_details')</a>
    </section>

@endsection