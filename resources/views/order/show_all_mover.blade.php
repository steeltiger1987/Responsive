@extends('layouts.app')

@section('content')
<section class="content">
    @if(session()->has('flash_message'))
        <span>{{ session()->get('flash_message') }}</span>
    @endif
    <table>
        <tbody>
            <tr>
                <td>@lang('order.id')</td>
                <td>@lang('order.s_items')</td>
                <td>@lang('order.l_items')</td>
                <td>@lang('order.distance')</td>
                <td>@lang('order.pick_up')</td>
                <td>@lang('order.drop_off')</td>
                <td>@lang('order.dates')</td>
                <td>@lang('order.expires')</td>
                <td>@lang('order.lowest_price')</td>
                <td>@lang('order.bids')</td>
                <td></td>
            </tr>

            @if(count($orders) == 0)
            <td>
                @if($needPreferences)
                    <td colspan="10">@lang('order.to_see_jobs_go_to_preferences') <a href="{{ url('/account/preferences/') }}" class="btn small green">@lang('order.setup_my_preferences')</a></td>
                @else
                    <td colspan="10">@lang('order.there_are_no_orders')</td>
                @endif
            </td>
            @else
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->small_items_amount()}}</td>
                    <td>{{$order->large_items_amount()}}</td>
                    <td>{{$order->distance}}</td>
                    <td>{{$order->pickup_address}}</td>
                    <td>{{$order->drop_off_address}}</td>
                    <td>{{($order->pick_up_dates == '') ? trans('order.all_day') : $order->pick_up_dates}}</td>
                    <td>{{$order->expiration_date}}</td>
                    <td>{{$order->lowestBidPrice()}}</td>
                    <td>{{$order->bidsCount()}}</td>
                    <td>
                    @if(Auth::user()->isMover())

                        @if(!Auth::user()->isApplied($order->id))
                            <a href="{{ url('/orders/bid/'. $order->id) }}" class="btn small green">@lang('order.apply_job')</a>
                        @else
                            <a href="{{ url('/orders/bid/'. $order->id) }}" class="btn small green disabled">@lang('order.you_have_applied')</a>
                        @endif

                    @endif
                        <a href="{{ url('/orders/show/'. $order->id) }}" class="btn small green">@lang('order.view_the_job')</a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</section>

@endsection