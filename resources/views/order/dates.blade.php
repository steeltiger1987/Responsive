@extends('layouts.order_create')

@section('content')

<script>
var old_time = {{ old('old_time', session('time-elapsed')) }}
</script>

<section class="content">

<section class="columns">

<article class="col col23">
<h1 class="entry-title">@lang("create_order.dates")</h1>

@include('errors.lists')



<form action="?step={{ $next_step }}" method="post" class="form" id="order-form">
    {{ csrf_field() }}

    <p>
        <input type="checkbox" name="negotiate_by_self" value="negotiate_by_self" id="negotiate_by_self"> @lang('create_order.will_negotiate_own')?<br>
    </p>

    <div class="pick-drop-times">
        <h3>@lang("create_order.pick_up")</h3>
        <div class="columns">
            <div class="col col4">
                <p>
                    <input id="pick_up_picker" name="pick_up_interval" autocomplete="off" value="{{ old('pick_up_interval', $fields['pick_up_interval']) }}" style="display: none;" type="text">
                </p>
            </div>
            <div class="col col34">
                <p>
                   <span>

                       <input data-toggle="toggle" type="checkbox" id="exact-time-pick-up-checkbox">
                       @lang("general.select_exact_time")
                   </span>
                </p>
                <div class="exact-time-pick-up">
                    <div class="inline-form-fit">
                        <div class="inline-form-fit-inside">
                                 <div class="inline-inputs" id="exact_time">
                                    <label for="time_pick_up">@lang("general.date")</label><input name="time_pick_up" id="time_pick_up">
                                </div>

                                <div class="inline-inputs" id="interval-pick-up">
                                    <label for="time_pick_up_interval">@lang("general.time")</label><input name="time_pick_up_interval" id="time_pick_up_interval" >
                                </div>

                                <div class="inline-inputs" >
                                    <input type="checkbox" name="interval" id="interval-pick-up-checkbox"> @lang("general.interval")
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3>@lang("create_order.drop_off")</h3>

        <div class="columns">
            <div class="col col4">
                <p>
                    <input id="drop_off_picker" name="drop_off_interval" autocomplete="off" style="display: none;" type="text" value="{{ old('drop_off_interval', $fields['drop_off_interval']) }}">
                </p>
            </div>
            <div class="col col34">
                <p>
                   <span>

                       <input data-toggle="toggle" type="checkbox" id="exact-time-drop-off-checkbox">
                       @lang("general.select_exact_time")
                   </span>
                </p>
                <div class="exact-time-drop-off">
                    <div class="inline-form-fit">
                        <div class="inline-form-fit-inside">

                                 <div class="inline-inputs" id="exact_time">
                                    <label for="time_drop_off">@lang("general.date")</label><input name="time_drop_off" id="time_drop_off">
                                </div>

                                <div class="inline-inputs" id="interval-drop-off">
                                    <label for="time_drop_off_interval">@lang("general.time")</label><input name="time_drop_off_interval" id="time_drop_off_interval">
                                </div>

                                <div class="inline-inputs">
                                    <input type="checkbox" name="interval-drop-off" id="interval-drop-off-checkbox"> @lang("general.interval")
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p class="padding-bottom">
        <label for="expiration_date">@lang("general.expiration_date")</label>
        <input name="expiration_date" id="expiration_date" value="">
    </p>

    <input type="hidden" id="estimate-time-field" name="old_time" value="{{ old('old_time', session('time-elapsed')) }}">
    <input type="hidden" id="yestarday" name="yestarday" value="{{ date("Y-m-d", strtotime( '-1 days' ) ) }}">

</form>
</article>

    <article class="col col3">
        @include('elements.sidebars.order_create')
    </article>

    </section>
</section>

@endsection