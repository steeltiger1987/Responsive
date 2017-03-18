
@extends('layouts.app')

@section('content')
    <section class="content">
        <H3>@lang('account.account')</H3>

        <ul>
            <li>
                <a href="{{ url('/orders/show') }}">@lang('account.orders')</a>
            </li>
            <li>
                <a href="{{ url('/account/billing-info') }}">@lang('account.edit_billing_info')</a>
            </li>
            <li>
                <a href="{{ url('/account/preferences') }} ">@lang('account.preferences')</a>
            </li>
            <li>
                <a href="{{ url('/account/details') }}">@lang('account.personal_details')</a>
            </li>

        </ul>

        <H4>@lang('account.your_cars')</H4>

        <table>
            <tr>
                <td>@lang('account.picture')</td>
                <td>@lang('account.producer')</td>
                <td>@lang('account.model')</td>
                <td>@lang('account.year')</td>
                <td>@lang('account.capacity')</td>
                <td></td>
                <td></td>
            </tr>
            @if(count($user->cars()->get()) > 0)
                @foreach($user->cars()->get() as $car)
                    <tr>
                        @if(count($car->images()->get()))
                            <td> <img src="{{ url('moving/uploads/car/'.$car->images()->get()->where('custom', 'cars')->first()->path) }}" class="car-img"></td>
                        @endif
                        <td>{{ $car->manufacturer }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->year }}</td>
                        <td>{{ $car->loading_capacity }}</td>
                        <td><a href="{{ url('/account/mover/car/edit/'. $car->id) }}" class="btn small green">@lang('account.edit')</a></td>
                        <td><a href="{{ url('/account/mover/car/delete/'. $car->id) }}" class="btn small green">@lang('account.delete')</a></td>
                    </tr>
                @endforeach
            @endif



        </table>

        <a href="{{ url('/account/mover/add-car') }}"><img src="{{ URL::asset('public/images/add-icon.png') }}" id="add_car"></a> @lang('account.add_car') <br>
    </section>
@endsection