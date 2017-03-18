@extends('layouts.modal')

@section('content')
    <div class="row">

        <div class="col-md-8">
            <div class="col-md-2">
                    <img src="{{ $user->getMoverImagePath() }}" width="100">
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        {{ $user->full_name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="stars starrr" data-rating="{{ $user->getRating() }}"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            @lang('modals.registered'): {{ $user->created_at }} <br>
            @if($user->hasInsurance())
                @lang('modals.insurance'): {{ $user->getInsuranceAmout()  }}  <br>
            @else
                @lang('modals.insurance'): @lang('modals.no');
            @endif
            @lang('modals.number_of_jobs'): {{ $user->getJobs() }}  <br>
        </div>
    </div>
    <hr>
    <h4>@lang('modals.reviews'):</h4>

    @if(count($user->ratings()->get()))
        @foreach($user->ratings()->get() as $rating)
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            @lang('modals.job') # {{ $rating->job_id }}
                        </div>

                        <div class="col-md-4">
                            <div class="stars starrr" data-rating="{{ $rating->rating }}"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $rating->comment }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    @else
        @lang('modals.mover_does_not_have_reviews')
    @endif




@endsection