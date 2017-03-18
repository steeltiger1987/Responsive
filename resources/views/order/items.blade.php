@extends('layouts.order_create')

@section('content')

<script>
var old_time = {{ old('old_time', session('time-elapsed')) }};
</script>

<section class="content">
        <section class="columns">
        <article class="col col23">
        <h1 class="entry-title">@lang("create_order.items")</h1>

        @include('errors.lists')


            <form action="?step={{ $next_step }}" method="post" class="form" id="order-form">
                {{ csrf_field() }}
                <div class="columns">
                    <article class="col col2">
                        @lang('create_order.small_items')<br>
                        <span> @lang('create_order.can_be_carried_by_one_person')</span> <br>
                        <div class="items">

                        </div> <br>
                        <a id="add_small_item_button"><img src="{{ URL::asset('public//images/add-icon.png') }}"></a><br>
                        <div class="small_items">

                         @foreach($fields['small_items'] as $item)
                            <li><a href="{{ url('/items/modal/' . $item->id) }}" class="small-item-choose">{{ $item->name }} x{{ $item->amount }}</a> <a class="delete-item" href="{{ url('/orders/item/delete/'. $item->id)}}">(delete)</a></li>
                        @endforeach
                        </div>
                    </article>

                    <article class="col col2">
                        @lang('create_order.large_items')<br>
                        <span>@lang('create_order.can_be_carried_by_two_persons')</span><br>
                        <div class="items">

                        </div><br>
                        <a id="add_large_item_button"><img src="{{ URL::asset('public/images/add-icon.png') }}"></a><br>
                        <ul class="large_items">
                        @foreach($fields['large_items'] as $item)
                            <li><a href="{{ url('/items/modal/'. $item->id)}}" class="large-item-choose">{{ $item->name }} x{{ $item->amount }}</a><a class="delete-item" href="{{ url('/orders/item/delete/'. $item->id)}}">(delete)</a></li>
                        @endforeach
                        </ul>
                    </article>
                </div>


                <p>
                    <input type="checkbox" name="will_help" value="1" id="will_help"> @lang('create_order.are_you_going_to_help')<br>
                </p>
                <p class="helper_count_input">
                    <label for="helper_count" class="inline">@lang('create_order.how_many_helpers_do_you_have')</label>
                    <select name="helper_count" id="helper_count" style="opacity: 0;">
                        @for($i = 0; $i < 11; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </p>


                <p>
                    <label for="move_comments">@lang('create_order.comments_about_the_move')</label>
                    <textarea name="move_comments" id="move_comments" value="{{ old("move_comments", $fields['move_comments']) }}" placeholder="@lang('create_order.optional')"></textarea>
                </p>

            <input type="hidden" id="estimate-time-field" name="old_time" value="{{ old('old_time', session('time-elapsed')) }}">
                <div class="items_count"></div>
            </form>
        </article>


        <article class="col col3">
            @include('elements.sidebars.order_create')
        </article>

    </section>
</section>

@endsection