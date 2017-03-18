@extends('layouts.app')

@section('content')

<section class="content">


            @include('errors.lists')
            @if(session()->has('flash_message'))
                <span>{{ session()->get('flash_message') }}</span>
            @endif
            <form action="{{ url('/account/mover/car/edit/'.$car->id) }}" method="post" class="form" id="order-form" enctype="multipart/form-data">
                {{ csrf_field() }}

                <section class="columns">
                    <article class="col col7">
                        <label for="car_photo">@lang('account.car_photo')</label>
                    </article>

                    <article class="col col5">
                        <img src="{{ $car->getCarImagePath() }}" style="width: 75px;">
                        <input type="file" name="car_photo" id="car_photo">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <img src="{{ $car->getDriverImagePath() }}" style="width: 75px;">
                        <label for="car_driver_photo">@lang('account.car_driver')</label>
                    </article>

                    <article class="col col5">
                        <input type="file" name="car_driver_photo" id="car_driver_photo">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <label for="manufacturer">@lang('account.manufacturer')</label>
                    </article>

                    <article class="col col5">
                        <input type="text" name="manufacturer" id="manufacturer" value="{{ $car->manufacturer }}">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <label for="model">@lang('account.model')</label>
                    </article>

                    <article class="col col5">
                        <input type="text" name="model" id="model" value="{{ $car->model }}">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <label for="year">@lang('account.year')</label>
                    </article>

                    <article class="col col5">
                        <input type="text" name="year" id="year" value="{{ $car->year }}">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <label for="loading_capacity">@lang('account.loading_capacity')</label>
                    </article>

                    <article class="col col5">
                        <input type="text" name="loading_capacity" id="loading_capacity" value="{{ $car->loading_capacity }}">
                    </article>
                </section>

                <p>
                    <button name="send" type="submit" value="1">@lang('account.edit_car')</button>
                </p>
            </form>
    </section>

@endsection