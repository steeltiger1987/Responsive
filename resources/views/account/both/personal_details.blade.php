@extends('layouts.app')

@section('content')

<div class="row">
<div class="col-md-1"></div>
    <div class="col-md-6">
        <form action="{{ url('/account/details/save') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <p>
                        <label for="name">@lang('account.first_name')</label>
                        <input id="name" name="name" value="{{ old('name', $user->name) }}">
                    </p>
                    <p>
                        <label for="last_name">@lang('account.last_name')</label>
                        <input id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                    </p>
                    <p>
                        <label for="email">@lang('account.email')</label>
                        <input id="email" name="email" value="{{ old('email', $user->email) }}">
                    </p>
                    <p>
                        <label for="phone_number">@lang('account.phone')</label>
                        <input id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                    </p>

                    <p>
                        <button name="cancel" type="submit" value="1">@lang('account.cancel')</button>
                        <button name="send" type="submit" value="1">@lang('account.save')</button>
                    </p>
                </div>


                @if(Auth::user()->isMover())
                    <div class="col-md-2">
                        <div class="pull-right">
                            <img src="{{ Auth::user()->getMoverImagePath() }}" width="150px">
                            <section class="columns">
                                <article class="col col7">
                                    <label for="mover_photo">@lang('account.photo')</label>
                                </article>

                                <article class="col col5">
                                    <input type="file" name="mover_photo" id="mover_photo">
                                </article>
                            </section>
                        </div>
                    </div>
                @endif
            </div>
        </form>

    </div>
</div>

@endsection