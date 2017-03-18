<article class="col col2">
    <div class="right">@lang('sidebars.auction_ended')</div>
    <div class="box-default">
        <h3>@lang('sidebars.customer_contact')</h3>
        <h4>{{ $order->user()->first()->full_name }}</h4>
        <p>@lang('sidebars.email'): {{ $order->user()->first()->email }}</p>
        <p>@lang('sidebars.phone'): {{ $order->user()->first()->phone_number }}</p>
    </div>
</article>