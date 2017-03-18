@extends('layouts.modal')

@section('content')
    <div class="modal-datepicker">
        <form id="prolong-form">
        {{ csrf_field() }}
            <p>
                <label for="expiration_date">@lang("general.expiration_date")</label>
                <input name="expiration_date" id="expiration_date" value="{{ old('expiration_date', $order->expiration_date) }}">
            </p>
            <input name="order_id" type="hidden" value="{{$order->id}}">
        </form>
    </div>

@endsection