@extends('layouts.app')

@section('content')

<section class="content">

            <h2>@lang('account.thank_you_mover_for_registering')</h2>
            @include('errors.lists')
            @if(session()->has('flash_message'))
                <span>{{ session()->get('flash_message') }}</span>
            @endif
            <form action="{{ url('/account/register/step/2') }}" method="post" class="form" id="order-form" enctype="multipart/form-data">
                {{ csrf_field() }}

                <section class="columns">
                    <article class="col col5">
                        <input type="checkbox" name="is_insured" value="1"> @lang('account.insurance')
                    </article>

                    <article class="col col5">
                        <label for="insurance_value">@lang('account.insurance')</label>
                        <input type="text" name="insurance_value" id="insurance_value" value="">
                    </article>
                </section>

                <h3>@lang('account.my_first_car')</h3>
                <h5>(@lang('account.after_your_registration_you_will_be_able_to_add_more_cars'))</h5>

                <section class="columns">
                    <article class="col col7">
                        <label for="car_photo">@lang('account.car_photo')</label>
                    </article>

                    <article class="col col5">
                        <input type="file" name="car_photo" id="car_photo">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
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
                        <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer') }}">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <label for="model">@lang('account.model')</label>
                    </article>

                    <article class="col col5">
                        <input type="text" name="model" id="model" value="{{ old('model') }}">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <label for="year">@lang('account.year')</label>
                    </article>

                    <article class="col col5">
                        <input type="text" name="year" id="year" value="{{ old('year') }}">
                    </article>
                </section>

                <section class="columns">
                    <article class="col col7">
                        <label for="loading_capacity">@lang('account.loading_capacity')</label>
                    </article>

                    <article class="col col5">
                        <input type="text" name="loading_capacity" id="loading_capacity" value="{{ old('loading_capacity') }}">
                    </article>
                </section>

                <p>
                    <button name="send" type="submit" value="1">@lang('account.finish_registration')</button>
                </p>


            </form>
    </section>

@endsection