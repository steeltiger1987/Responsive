@extends('layouts.order_create')

@section('content')

<article class="col">
<h1 class="entry-title">@lang("create_order.registration_completed")</h1>

@include('errors.lists')

@lang("create_order.your_order_completed_you_can_now_login")

<a href="{{ url('/orders/show') }}" class="btn small green">@lang('create_order.continue_to_orders')</a>

</article>

@endsection