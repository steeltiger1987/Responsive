@extends('layouts.admin')
@section('content')

    @if($mover->isActivated())
        <a href="{{url('/admin/mover/'.$mover->id.'/deactivate')}}" class="btn medium green">Deactivate</a>
    @else
        <a href="{{url('/admin/mover/'.$mover->id.'/activate')}}" class="btn medium green">Activate</a>
    @endif

    <h3>Comissions</h3>
    <form action="{{ url('/admin/account/mover/comission') }}" method="POST" >
        {{ csrf_field() }}
        <p class="half">
            <lable for="comission">Comissions</lable>
            <input id="comission" type="text" name="comission" value="{{ $mover->comission }}">
        </p>
        <input type="hidden" name="userId" value="{{ $mover->id }}">
        <p>
            <button name="send" type="submit" value="1">Update</button>
        </p>
    </form>

    <div class="row">
            <div class="col-md-8">
                <div class="col-md-2">
                        <img src="{{ $mover->getMoverImagePath() }}" width="100">
                </div>
            </div>
    </div>

    <h3>Personal info</h3>
    <div class="row">
        <div class="col-md-6">
            Name: <br>
            Email: <br>
            Phone number: <br>
            Image name: <br>
        </div>
        <div class="col-md-6">
            {{ $mover->fullname }} <br>
            {{ $mover->email }} <br>
            {{ $mover->phone_number }} <br>
            {{ $mover->images()->first() != null ? $mover->images()->first()->path : 'N/A' }} <br>
        </div>
    </div>

    <hr>

    <h3>Moving related</h3>
    <div class="row">
        <div class="col-md-6">
            Base address
        </div>
        <div class="col-md-6">
            {{ $mover->base_address === '' ? 'N/A' : $mover->base_address}}
        </div>
    </div>
    <hr>
        @if($mover->billingInfo()->first() != null)
        <h3>Invoicing</h3>
        <div class="row">
            <div class="col-md-6">
                Company name <br>
                ICO <br>
                DIC <br>
                Company Address <br>
                City <br>
                Invoicing Mail <br>
                Bank Account Number <br>
                Credit Top Up Variable Symbol <br>
                Comission <br>
            </div>

            <div class="col-md-6">
                {{ $mover->billingInfo()->first()->company_name }} <br>
                {{ $mover->billingInfo()->first()->business_id }} <br>
                {{ $mover->billingInfo()->first()->tax_number }} <br>
                {{ $mover->billingInfo()->first()->address }} <br>
                {{ $mover->billingInfo()->first()->city }} <br>
                {{ $mover->billingInfo()->first()->email_invoice }} <br>
                {{ $mover->billingInfo()->first()->bank_account}} <br>
                {{ $mover->getVariable() }} <br>
                {{ $mover->comission }}

            </div>
        </div>
        @endif


@endsection