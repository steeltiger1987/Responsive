@extends('layouts.modal')

@section('content')
    <div class="text-center align-middle" id="first-step-approve">
        <h3 class="top">@lang('modals.would_you_like_to_hire')</h3>

        <div class="row">
            {{ $mover->full_name }}
        </div>

        <div class="row">
            @lang('modals.amount'): {{ $order->getBid($mover->id) }} {{ currency()->getUserCurrency() }}
        </div>

        <div class="row">
            <div class="col-md-6 col-xs-6">
                <a id="close" class="btn large green prolong">@lang('modals.no')</a>
            </div>

            <div class="col-md-6 col-xs-6">
                <a id="hire" class="btn large green prolong">@lang('modals.yes_hire')</a>
            </div>
        </div>
    </div>

    <div class="text-center aligncenter" id="second-step-approve" style="display: none">
          <h3 class="top">@lang('modals.congratulations_for_selecting_provider')</h3>

          <div class="row">
              {{ $mover->full_name }}
          </div>

          <div class="row">
            @lang('modals.email'): {{ $mover->email }}
          </div>

          <div class="row">
              @lang('modals.phone'): {{ $mover->phone_number }}
            </div>

          <div class="row">
          <div class="col-md-6 col-xs-6"></div>
              <div class="col-md-6 col-xs-6">
                  <a id="close" class="btn large green prolong">@lang('modals.close')</a>
              </div>
          </div>
    </div>

    <div id="form" class="hidden">
        <form id="job_details_form">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $order->id }}" name="order_id">
            <input type="hidden" value="{{ $mover->id }}" name="user_id">
            <input type="hidden" value="{{ $bid->id }}" name="bid_id">
        </form>
    </div>
@endsection