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
                <td>@lang('order.done')</td>
                <td></td>
                <td>@lang('order.price')</td>
                <td></td>
            </tr>

            @if(count($jobs) == 0)
                @lang('order.no_jobs')
            @else
                @foreach($jobs as $job)
                <tr>
                    <td>{{$job->order()->first()->id}}</td>
                    <td>{{$job->order()->first()->small_items_amount()}}</td>
                    <td>{{$job->order()->first()->large_items_amount()}}</td>
                    <td>{{$job->order()->first()->distance}}</td>
                    <td>{{$job->order()->first()->pickup_address}}</td>
                    <td>{{$job->order()->first()->drop_off_address}}</td>
                    <td>{{($job->order()->first()->pick_up_dates == "") ? trans('order.all_day') : $job->order()->first()->pick_up_dates}}</td>
                    <td> @if($job->order()->first()->isWon()) @lang('order.no') @else @lang('order.yes') @endif</td>
                    <td>@if($job->order()->first()->isWon()) <a href="{{ url('/job/end/'.$job->id) }}" class="btn small green">@lang('order.mark_completed')</a> @endif </td>
                    <td>{{$job->bid()->first()->bid}} @lang('general.'.currency()->getUserCurrency())</td>
                    <td><a href="{{ url('/orders/show/'.$job->order()->first()->id) }}" class="btn small green">@lang('order.view_job')</a></td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</section>

@endsection