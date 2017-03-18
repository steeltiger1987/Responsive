@extends('layouts.preferences')

@section('content')
    <div class="content">
        <h2>@lang('account.preferences')</h2>
        <h5>@lang('account.please_select_the_countries_and_regions')</h5>
        <div id="maps">
                <?php $i = 0; ?>
                @foreach($countries as $country)

                <div id="map{{$i}}" country="{{ $country->get(0)->countryModified }}" country="{{ $country->get(0)->identifierModified }}" class="mapsvg mapsvg-responsive map" style="width: 350px">

                </div>
                <div country="{{$country->get(0)->countryModified}}">{{ $country->get(0)->countryFullName }} <a href="{{ url('/movers/preferences/remove/country/'.$country->get(0)->countryModified) }}" country="{{ $country->get(0)->countryModified }}" class="btn small green removeButton">@lang('account.remove')</a></div>

                <?php ++$i; ?>
                @endforeach
            </div>

            <div style="display: none">
                <div id="map_regions_selected">{{ count($regions) }}</div>
                @for($i = 0; $i < count($regions); $i++)
                <div id="map_region{{$i}}">{{ $regions->get($i)->identifier }}</div>
                @endfor
            </div>

            <h5>@lang('account.add_new_country')</h5>
            <select id="country" name="country"></select>

            <br><br>
            <div class="row top">
                <form action="{{url('/preferences/account/action')}}" method="POST" >
                    {{ csrf_field() }}
                    <div class="hidden-items">
                        @foreach($regions as $region)
                            <div id="{{ $region->identifier }}"><input type="hidden" name="region_name[]" value="{{ $region->region_name }}">
                            <input type="hidden" name="identifier[]" value="{{ $region->identifier }}">
                            <input type="hidden" name="country[]" value="{{ substr($region->identifier, 0, 2) }}">
                            <input type="hidden" name="user_id[]" value="{{ $region->user_id }}"> </div>
                        @endforeach
                    </div>


                    <div class="pull-right"><button name="cancel" type="submit" value="1">@lang('account.cancel')</button></div>
                    <div class="pull-right"><button name="send" type="submit" value="1">@lang('account.save')</button></div>
                </form>

            </div>
    </div>


@endsection