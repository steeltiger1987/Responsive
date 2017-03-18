@extends('layouts.admin')

@section('content')

<form action="{{ url('/admin/account/mover/make/payment') }}" method="POST" style="height:500px">
    {{ csrf_field() }}
    <p class="half">
        <label for="user_id">Select mover</label>

            <select id="user_id" class="selectpicker" data-live-search="true" name="user_id">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->getVariable() }}</option>
                    @endforeach
            </select>
    </p>
    <p class="half">
        <lable for="amount">Amount</lable>
        <input id="amount" type="text" name="amount">
    </p>
    <p>
        <button name="send" type="submit" value="1">Send money</button>
    </p>
</form>

@endsection