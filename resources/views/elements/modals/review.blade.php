@extends('layouts.modal')

@section('content')
    <div class="row" id="post-review-box">
        <div class="col-md-12">
            <form accept-charset="UTF-8" action="" method="post" id="review-form">
                {{ csrf_field() }}
                <input id="ratings-hidden" name="rating" type="hidden">
                <input type="hidden" name="user_id" value="{{ $job->getUser()->id }}">
                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="@lang('modals.enter_your_review_placeholder')" rows="5"></textarea>

                <div class="text-right">
                    <div class="stars starrr star_change" data-rating="0"></div>
                </div>
            </form>
        </div>
    </div>
@endsection