@extends('layouts.admin')

@section('content')

<form action="{{ url('/admin/order/'. $order->id .'/note/add') }}" method="post" class="form" id="order-form">
            {{ csrf_field() }}

            @include('errors.lists')
              <div class="row">
                <div class="col-xs-3">
                    <label for="note">Note:</label>
                    <textarea name="note" id="note" >{{ $order->note or old('note') }}</textarea>
                </div>
              </div>
            <br>
           <button name="send" type="submit" value="1" class="btn green small">Add note</button>
        </form>

@endsection