@extends('layouts.order_create')

@section('content')

<script>
var old_time = {{ old('old_time', session('time-elapsed')) }}
</script>

<section class="content">
    <section class="columns">
        <article class="col col23">
            <h1 class="entry-title">@lang("create_order.DATE, TIME, LOCATIONS")</h1>

            @include('errors.lists')

           <form action="?step={{ $next_step }}" method="post" class="form" id="order-form">
               {{ csrf_field() }}

              <div class="clearfix">
                   <p class="half">
                       <label for="name">@lang("create_order.name")</label><input name="name" id="name" value="{{ old('name') }}">
                   </p>
                   <p class="half">
                      <label for="last_name">@lang("create_order.last_name")</label><input name="last_name" id="last_name" value="{{ old('last_name') }}">
                  </p>
              </div>

             <div class="clearfix">
                  <p class="half">
                      <label for="phone_number">@lang("create_order.phone_number")</label><input name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
                  </p>

                  <p class="half">
                     <label for="email">@lang("create_order.email")</label><input name="email" id="email" value="{{ old('email') }}">
                 </p>
             </div>
               <div class="clearfix">
                    <p class="half">
                        <label for="password">@lang("create_order.password")</label><input type="password" name="password" id="password" value="{{ old('password') }}">
                    </p>

                    <p class="half">
                       <label for="repeat_password">@lang("create_order.repeat_password")</label><input type="password" name="password_confirmation" id="repeat_password" value="{{ old('repeat_password') }}">
                   </p>
               </div>

               <div class="clearfix">
                    <input type="checkbox" name="aggreement"> @lang('create_order.i_aggree') <a href="/terms-and-conditions">@lang('create_order.terms_and_conditions')</a>
               </div>

            <input type="hidden" id="estimate-time-field" name="old_time" value="{{ old('old_time', session('time-elapsed')) }}">

           </form>


        </article>

        <article class="col col3">
            @include('elements.sidebars.order_create')
        </article>

    </section>

</section>

@endsection