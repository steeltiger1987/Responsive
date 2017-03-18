<article class="col col2">
@lang('sidebars.auction_ended')
    <div class="box-default">

        <h3>@lang('sidebars.your_provider')</h3>
                <p>
                    <table class="table-bordered" style="width:100%">
                        <tr>
                            <td ><img src="{{ $order->job()->first()->getCar()->getCarImagePath() }}"> </td>
                            <td >{{ $order->job()->first()->user()->first()->full_name }}</td>
                            <td >@lang('sidebars.bid_is'): {{ $order->job()->first()->bid()->first()->bid }} @lang('general.' . currency()->getUserCurrency())
                            @if(Auth::user()->isUser())
                                <br>
                                <a href="/movers/profile/{{ $order->job()->first()->user()->first()->id }}" class="btn small green user-profile">
                                    @lang('sidebars.view_profile')
                                </a>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td ><img src="{{ $order->job()->first()->getCar()->getDriverImagePath() }}"></td>
                            <td colspan="3">{{ $order->job()->first()->getCar()->full_car_name }} <br>
                            @lang('sidebars.loading_capacity'): {{ $order->job()->first()->getCar()->loading_capacity }} </td>
                        </tr>
                        <tr><td colspan="3">
                            @if($order->job()->first()->bid()->first()->ride_along)
                                @lang('sidebars.ride_along'): @lang('sidebars.yes') <br>
                            @else
                                @lang('sidebars.rode_along'): @lang('sidebars.no')<br>
                            @endif
                            @if($order->job()->first()->bid()->first()->movers)
                                @lang('sidebars.movers'): @lang('sidebars.yes')<br>
                                @lang('sidebars.how_many'): {{ $order->job()->first()->order()->first()->helper_count }}<br>
                            @else
                                @lang('sidebars.movers'): @lang('sidebars.no')<br>
                            @endif
                            @if($order->job()->first()->bid()->first()->spolumoving)
                                @lang('sidebars.spolumoving'): @lang('sidebars.yes')<br>
                            @else
                                @lang('sidebars.spolumoving'): @lang('sidebars.no')<br>
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <h4>Contacts</h4>
                                @lang('sidebars.email'): {{ $order->job()->first()->user()->first()->email }} <br>
                                @lang('sidebars.phone'): {{ $order->job()->first()->user()->first()->phone_number }}
                            </td>
                        </tr>
                            @if(Auth::user()->isUser())
                        <tr>
                            <td colspan="3">
                                @if($order->job()->first()->isRated())
                                    <a href="{{ url('/review/'. $order->job()->first()->id) }}" class="btn small green disabled" id="review-mover">
                                        @lang('sidebars.you_rated')
                                    </a>
                                @else
                                    <a href="{{ url('/review/'. $order->job()->first()->id) }}" class="btn small green" id="review-mover">
                                        @lang('sidebars.review_provider')
                                    </a>
                                @endif
                            </td>
                        </tr>
                            @endif
                    </table>
                </p>
            </div>
</article>