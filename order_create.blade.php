<!-- Side -->
<div class="sidebar">
    <div class="order-steps">
        <ul>
            <li class="active"><a href="?step=address" id="address">1. @lang('create_order.addresses')</a></li>
            <hr>
            @if($active == 'items' || $active == 'dates' || $active == 'account')
            <li><a href="?step=items" id="items">2. @lang('create_order.items')</a></li>
            @else
            <li>2. @lang('create_order.items')</li>
            @endif
            <hr>
            @if($active == 'dates' || $active == 'account')
            <li><a href="?step=dates" id="dates">3. @lang('general.dates')</a></li>
            @else
            <li>3. @lang('general.dates')</li>
            @endif
            <hr>
            @if(!Auth::check())
                @if($active == 'account')
                <li><a href="?step=account" id="account">4. @lang('general.account')</a></li>
                @else
                <li>4. @lang('general.account')</li>
                @endif
            @endif
            <hr>
        </ul>

        <div class="time-block">
            <span>@lang('create_order.estimate_time')</span>
            <span id="estimate-time">0 </span>h
        </div>

        <button id="order-button" name="order" type="button" value="1">@lang('create_order.next')</button>
    </div>


</div>