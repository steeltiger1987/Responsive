@extends('layouts.app')

@section('content')
<section class="content">
    <br>
    <div class="row">
        <div class="col-xs-2">
            <h3>@lang('order.my_jobs')</h3>
        </div>
        <div class="col-xs-1">
            <a href="/orders/create" class="btn large green">@lang('order.create_new')</a>
        </div>

    </div>
    <br>
    @if(session()->has('flash_message'))
        <span>{{ session()->get('flash_message') }}</span>
    @endif
    <table>
        <tbody>
            <tr>
                <td>@lang('order.id')</td>

                <td>@lang('order.pick_up')</td>
                <td>@lang('order.drop_off')</td>
                <td>@lang('order.posted')</td>
                <td>@lang('order.offers')</td>
                <td>@lang('order.status')</td>
                <td>@lang('order.ends')</td>
                <td></td>
            </tr>

            @if(count($orders) == 0)
            <td>
                <td colspan="10">@lang('order.you_dont_have_orders') <a href="{{ url('/orders/create/') }}">@lang('order.here')</a></td>
            </td>
            @else
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->pickup_address}}</td>
                    <td>{{$order->drop_off_address}}</td>
                    <td>{{$order->created_at }}</td>
                    <td>{{$order->bidsCount()}}</td>
                    <td>{{$order->status}}</td>
                    <td>{{$order->expiration_date}}</td>
                    <td>
                        @if($order->status == 'active')
                        <a href="{{ url('/orders/prolong/'. $order->id) }}" class="btn small green prolong">@lang('order.prolong')</a>
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