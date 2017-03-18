@extends('layouts.app')

@section('content')

    <section class="content">
    <span>@lang("order.bid_information_text")</span>
        <form action="{{ url('/orders/bid/create') }}" method="post" class="form" id="order-form">
            {{ csrf_field() }}

            @include('errors.lists')
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="user_id" value="{{ $user->id }}">


              <div class="row">
                <div class="col-xs-3">
                    <label for="bid">@lang("order.bid") </label>
                    <input name="bid" id="bid" value="{{ old('bid') }}" >
                </div>
                    <div class="col-xs-2">
                    <label for="currency">@lang("order.currency")</label>
                    <select name="currency" id="currency" style="opacity: 0;">
                        @foreach(currency()->getCurrencies() as $currency)
                        <option value="{{ $currency['code'] }}">{{ $currency['code'] }}</option>
                        @endforeach
                    </select>
                </div>
              </div>





           <p>
            <label for="car_id">@lang("order.car")</label>
                <select name="car_id" id="car_id" style="opacity: 0;">
                    @foreach($user->cars()->get() as $car)
                        <option value="{{ $car->id }}">{{ $car->manufacturer . ' ' . $car->model }}</option>
                    @endforeach
                </select>
           </p>

           <p>
             <div class="inline-inputs" >
                <input type="checkbox" name="ride_along" id="ride_along" value="1"> @lang("order.ride_along")

                <select name="ride_along_client" id="ride_along_client" style="opacity: 0;">
                    <option value="0" selected>0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
             </div>
           </p>
           <p>
           <div class="inline-inputs" >
               <input type="checkbox" name="movers" id="movers" value="1"> @lang("order.movers")

               <select name="movers_count" id="movers_count" style="opacity: 0;">
                   @for($i = 0; $i < 11; $i++)
                       <option value="{{ $i }}" @if($i == 0) selected @endif>{{ $i }}</option>
                   @endfor
               </select>
           </div>
          </p>
          <p>
             <div class="inline-inputs" >
                 <input type="checkbox" name="spolumoving" id="spolumoving" value="1"> @lang("order.spolumoving")
             </div>
            </p>

           <button name="send" type="submit" value="1">@lang("order.place_bid")</button>
        </form>
    </section>
@endsection