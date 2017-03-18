@extends('layouts.app')

@section('content')

    <section class="content">
        <form action="{{ url('/orders/bid/edit/'. $bid->id) }}" method="post" class="form" id="order-form">
            {{ csrf_field() }}

            @include('errors.lists')
           <p>
               <label for="bid">@lang("order.bid") ( @lang('general.'.$currency) )</label>
               <input name="bid" id="bid" value="{{ old('bid', $bid->bid) }}">
           </p>

           <p>
            <label for="car_id">@lang("order.car")</label>
                <select name="car_id" id="car_id" style="opacity: 0;">
                    @foreach($user->cars()->get() as $car)
                        <option value="{{ $car->id }}" @if($car->id == $bid->car_id) selected @endif>{{ $car->manufacturer . ' ' . $car->model }}</option>
                    @endforeach
                </select>
           </p>

           <p>
             <div class="inline-inputs" >
                <input type="checkbox" name="ride_along" id="ride_along" value="1"> @lang("order.ride_along")

                <select name="ride_along_client" id="ride_along_client" style="opacity: 0;">
                    @for($i = 0; $i < 11; $i++)
                    <option value="{{ $i }}" @if($i == $bid->ride_along_client) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
             </div>
           </p>
           <p>
           <div class="inline-inputs" >
               <input type="checkbox" name="movers" id="movers" value="1" @if($bid->movers == 1) checked @endif> @lang("order.movers")

               <select name="movers_count" id="movers_count" style="opacity: 0;" >
                @for($i = 0; $i < 11; $i++)
                    <option value="{{ $i }}" @if($i == $bid->movers_count) selected @endif>{{ $i }}</option>
                @endfor
               </select>
           </div>
          </p>
          <p>
             <div class="inline-inputs" >
                 <input type="checkbox" name="spolumoving" id="spolumoving" value="1" @if($bid->spolumoving == 1) checked @endif> @lang("order.spolumoving")
             </div>
            </p>

           <button name="send" type="submit" value="1">@lang("order.place_bid")</button>
        </form>
    </section>
@endsection