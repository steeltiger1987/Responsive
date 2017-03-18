@extends('layouts.app')

@section('content')


    <section class="content">
        <section class="columns">
            <!-- Form part -->
            <article class="col col2">
                @include('errors.lists')
                @if(session()->has('flash_message'))
                    <span>{{ session()->get('flash_message') }}</span>
                @endif
                <form action="{{ url('/account/billing-info') }}" method="post" class="form" id="order-form">
                    {{ csrf_field() }}

                    @if(!is_null($billingInfo))
                    <input type="hidden" name="id" value="{{ $billingInfo->id }}">
                    @endif
                    <p>
                        <label for="billing_name">@lang("account.billing_name")</label>
                        <input name="billing_name" id="billing_name" value="{{ !is_null($billingInfo) ? $billingInfo->billing_name : old('billing_name') }}" required>
                    </p>

                    <p>
                        <label for="company_name">@lang("account.company_name")</label>
                        <input name="company_name" id="company_name" value="{{ !is_null($billingInfo) ? $billingInfo->company_name : old('company_name') }}" required>
                    </p>

                    <p>
                        <label for="business_id">@lang("account.business_id")</label>
                        <input name="business_id" id="business_id" value="{{ !is_null($billingInfo) ? $billingInfo->business_id : old('business_id') }}" required>
                    </p>

                    <p>
                        <label for="tax_number">@lang("account.tax_number")</label>
                        <input name="tax_number" id="tax_number" value="{{ !is_null($billingInfo) ? $billingInfo->tax_number : old('tax_number') }}">
                    </p>

                    <p>
                        <label for="address">@lang("account.address")</label>
                        <input name="address" id="address" value="{{ !is_null($billingInfo) ? $billingInfo->address : old('address') }}" required>
                    </p>
                    <p>
                        <label for="city">@lang("account.city")</label>
                        <input name="city" id="city" value="{{ !is_null($billingInfo) ? $billingInfo->city : old('city') }}" required>
                    </p>
                     <p>
                         <label for="country">@lang("account.country")</label>
                         <input name="country" id="country" value="{{ !is_null($billingInfo) ? $billingInfo->country : old('country') }}" required>
                     </p>

                    <p>
                        <label for="email_invoice">@lang("account.email_invoice")</label>
                        <input name="email_invoice" id="email_invoice" value="{{ !is_null($billingInfo) ? $billingInfo->email_invoice : old('email_invoice') }}" required>
                    </p>
                    <p>
                        <label for="bank_account">@lang("account.bank_account")</label>
                        <input name="bank_account" id="bank_account" value="{{ !is_null($billingInfo) ? $billingInfo->bank_account : old('bank_account') }}" required>
                    </p>

                    <button name="send" type="submit" value="1">@lang('account.save')</button>

                </form>
            </article>

        <article class="col col2">
            @if(Auth::user()->getBalance() < 0)
            <h2 style="color:red">@lang('account.balance'): {{ Auth::user()->getBalance() }} @lang('general.'.currency()->getUserCurrency())</h2>
            <h6>(@lang('account.please_top_up_at_least') {{ abs(Auth::user()->getBalance()) }}  @lang('general.'.currency()->getUserCurrency()))</h6>
            @else
            <h2>@lang('account.balance'): {{ Auth::user()->getBalance() }} @lang('general.'.currency()->getUserCurrency())</h2>
            <h6>(@lang('account.you_are_able_to_bid'))</h6>
            @endif

            <div class="row">
                <h3>@lang('account.how_to_top_up')</h3>
                <h6>@lang('account.there_are_two_options')</h6>
            </div>
            <div class="row">
                1. @lang('account.bank_transfer') <br><br>
                    @lang('account.send_money'): {{ $bankAccount }} / {{ $bankCode }}
                    @lang('account.variable_symbol'): {{ auth()->user()->getVariable() }}
            </div>
            <div class="row">
                2. @lang('account.credit_card')
                <form name="form1" action="{{ config('trustpay.URL') }}" method="POST">
                    <input type="hidden" name="AID" value="{{ config('trustpay.AID') }}">
                    <input type="text" name="AMT">
                    <input type="hidden" name="CUR" value="{{ config('trustpay.CUR') }}">
                    <input type="hidden" name="REF" value="{{ "ORDER_" . auth()->user()->id  }}">
                    <input type="submit" name="@lang('account.pay_by_card')">
                </form>
            </div>
        </article>
        </section>
    </section>


@endsection