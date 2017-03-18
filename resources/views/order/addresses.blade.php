@extends('layouts.order_create')

@section('content')

	<script>
	var old_time = {{ session('time-elapsed', 0) }};
	</script>

	<section class="content">

        <section class="columns">

            <article class="col col23">
            <h1 class="entry-title">@lang("create_order.addresses")</h1>

            @include('errors.lists')
            <form action="?step={{ $next_step }}" method="post" class="form" id="order-form">
                {{ csrf_field() }}
                <p>
                    <label for="pickup_address">@lang("create_order.Pick Up address")</label>
                    @if(isset($from))
                    <input name="pickup_address" id="pickup_address" value="{{ old('pickup_address', $from) }}">
                    @else
                    <input name="pickup_address" id="pickup_address" value="{{ old('pickup_address', $fields['pickup_address']) }}">
                    @endif
                </p>
                <p class="half">
                    <label for="pickup_floor">@lang("create_order.Floor")</label>

                    <select name="pickup_floor" id="pickup_floor" style="opacity: 0;">
                        @for($i = 0; $i < 25; $i++)
                            @if(old('drop_off_address', $fields['pickup_floor']) == $i)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </p>
                <p class="half">
                    <label for="pickup_elevator">@lang("create_order.Elevator")</label>

                    <select name="pickup_elevator" id="pickup_elevator" style="opacity: 0;">
                        @if(old('pickup_elevator', $fields['pickup_elevator']) === 'Yes')
                            <option value="Yes" selected>@lang('general.yes')</option>
                            <option value="No">@lang('general.no')</option>
                        @else
                            <option value="Yes">@lang('general.yes')</option>
                            <option value="No" selected>@lang('general.no')</option>
                        @endif

                    </select>

                </p>
                <p>
                    <label for="drop_off_address">@lang("create_order.Drop off address")</label>
                    @if(isset($to))
                        <input name="drop_off_address" id="drop_off_address" value="{{ old('drop_off_address', $to) }}">
                    @else
                        <input name="drop_off_address" id="drop_off_address" value="{{ old('drop_off_address', $fields['drop_off_address']) }}">
                    @endif

                </p>
                <p class="half">
                    <label for="topic">@lang("create_order.Floor")</label>

                    <select name="drop_off_floor" id="drop_off_floor" style="opacity: 0;">
                        @for($i = 0; $i < 25; $i++)
                            @if($fields['drop_off_floor'] == $i)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </p>

                <p class="half">
                    <label for="topic">@lang("create_order.Elevator")</label>
                        <select name="drop_off_elevator" id="drop_off_elevator" style="opacity: 0;">
                            @if(old('drop_off_elevator', $fields['drop_off_elevator']) === 'Yes')
                                <option value="Yes" selected>@lang('general.yes')</option>
                                <option value="No">@lang('general.no')</option>
                            @else
                                <option value="Yes">@lang('general.yes')</option>
                                <option value="No" selected>@lang('general.no')</option>
                            @endif
                        </select>
                </p>
                <input type="hidden" id="distance" name="distance" value="0">
                <input type="hidden" id="drop_off_street" name="drop_off_street" >
                <input type="hidden" id="drop_off_house_number" name="drop_off_house_number" >
                <input type="hidden" id="drop_off_city" name="drop_off_city" >
                <input type="hidden" id="drop_off_zip" name="drop_off_zip" >
                <input type="hidden" id="drop_off_country" name="drop_off_country" >
                <input type="hidden" id="drop_off_lat" name="drop_off_lat" >
                <input type="hidden" id="drop_off_long" name="drop_off_long" >
                <input type="hidden" id="drop_off_administrative_area" name="drop_off_administrative_area" >

                <input type="hidden" id="pickup_street" name="pickup_street" value="0">
                <input type="hidden" id="pickup_house_number" name="pickup_house_number">
                <input type="hidden" id="pickup_city" name="pickup_city">
                <input type="hidden" id="pickup_zip" name="pickup_zip">
                <input type="hidden" id="pickup_country" name="pickup_country">
                <input type="hidden" id="pickup_lat" name="pickup_lat">
                <input type="hidden" id="pickup_long" name="pickup_long">
                <input type="hidden" id="pickup_administrative_area" name="pickup_administrative_area">
                <input type="hidden" id="estimate-time-field" name="old_time" value=" @if(!session()->exists('time-elapsed')) 0 @else {{ session()->get('time-elapsed')}} @endif ">
            </form>
            </article>

            <article class="col col3">
                @include('elements.sidebars.order_create')
            </article>

        </section>
    </section>


@endsection
