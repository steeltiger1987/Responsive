@extends('layouts.app')

@section('content')
<style>
    .orderbtn:hover{
        color:#545a8c; opacity: 0.9;
    }
    .fleft{
        float:left;
    }
    .width100{
        width:100%;
    }
    .width40{
        width:50px;
    }
    .width40 img{
        width:50px;
    }
    .width80{
        width:70%;
    }
    .tupper{
        text-transform: uppercase;
        line-height:30px;
        font-size: 18px;
        font-weight:normal;  
    }
    .strongtds{
        font-size: 18px;
        color: #000 !important;
        
        font-weight: normal;
    }
    .colortds{
        color:#545A8E;
        font-size: 18px;
        font-weight: normal;
    }
    .font18 tr td{
        font-size: 18px;
        color: #000;
    }
    .padding1 tr td{
        padding:2px;
        margin:0; 
    }
    .padding1{
        margin:0;
    }
    .h4_head{
        width:100%;text-align:right;font-weight: normal;
    }
  .capF{
    text-transform: lowercase;
  }
  .getusercurrency{
    text-align: center;
  }
  @media screen and (max-width: 767px){

    .bidBtn{
        width:100%;float:right;text-align: right;
    }
    .orderbtn{
        padding: 21px 22px;
    }
  }
  @media screen and (max-width: 2000px) and (min-width: 768px) {

    .bidBtn{
        width:80%;float:right;text-align: right;
    }
  }
</style>
<section class="content">
    <section class="columns">
        <article class="col col2">
            <h4># {{ $order->id }} @lang('order.moving')</h4>
            <div class="box-default">
                @if(Auth::user()->isMover())
                    <h4>@lang('order.details')</h4>
                    <table>
                        <tbody>
                            <tr>
                                <td><strong>@lang('order.distance')</strong>s</td>
                                <td>{{ $order->distance }}</td>
                            </tr>
                            <tr>
                                <td>@lang('order.estimate_time')</td>
                                <td>{{ $order->old_time }} h</td>
                            </tr>
                        </tbody>
                    </table>
                @endif

                @if(Auth::user()->isMover())
                <h4>
                <div class="width100">
                    <div class="fleft width40">
                        <img src="{{ URL::asset('/public/images/address.png')}}"/>        
                    </div>
                    <div class="fleft tupper">
                        &nbsp;@lang('order.addresses')
                    </div>
                    <div style="clear:both;"></div>
                </div>
                </h4>

                @else

                <h4>
                <div class="width100">
                    <div class="fleft width40">
                        <img src="{{ URL::asset('/public/images/address.png')}}"/>        
                    </div>
                    <div class="fleft tupper">
                        &nbsp;@lang('order.addresses') ( {{ $order->distance }} @lang('order.km') )
                    </div>
                    <div style="clear:both;"></div>
                </div>
                </h4>

                @endif
                <table>
                    <tbody>
                        <tr>
                            <td></td>
                            <td class="colortd">@lang('order.from')</td>
                            <td class="colortd">@lang('order.to')</td>
                        </tr>
                        <tr>
                            <td style="width:15%"><strong class="strongtds">@lang('order.street')</strong></td>
                            <td width="40" class="bordertd">{{ $order->pickup_street }} {{ $order->pickup_house_number }}</td>
                            <td width="40" class="bordertd">{{ $order->drop_off_street }} {{ $order->drop_off_house_number }}</td>
                        </tr>

                        <tr>
                            <td><strong class="strongtds">@lang('order.city')</strong></td>
                            <td class="bordertd">{{ $order->pickup_city }}</td>
                            <td class="bordertd">{{ $order->drop_off_city }}</td>
                        </tr>

                        <tr>
                            <td><strong class="strongtds">@lang('order.zip')</strong></td>
                            <td class="bordertd">{{ $order->pickup_zip }}</td>
                            <td class="bordertd">{{ $order->drop_off_zip }}</td>
                        </tr>

                        <tr>
                            <td><strong class="strongtds">@lang('order.country')</strong></td>
                            <td class="bordertd">{{ $order->pickup_country }}</td>
                            <td class="bordertd">{{ $order->drop_off_country }}</td>
                        </tr>
                    </tbody>
                </table>

                
                <h4>
                <div class="width100">
                    <div class="fleft width40">
                        <img src="{{ URL::asset('/public/images/cal.png')}}"/>       
                    </div>
                    <div class="fleft tupper">
                        &nbsp;@lang('order.dates_and_times')
                    </div>
                    <div style="clear:both;"></div>
                </div>
                </h4>

                @if($order->pick_up_dates != "" ||  $order->drop_off_dates != "")
                <table class="font18">
                    <tbody>

                        <tr>
                            <td class="width80"><strong class="colortd">@lang('order.pick_up_date')</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong class="strongtds">@lang('order.date')</strong></td>
                            <td>{{ $order->pick_up_dates == "" ? trans('order.all_day') : $order->pick_up_dates }}</td>
                        </tr>
                        <tr>
                            <td><strong class="strongtds">@lang('order.time')</strong></td>
                            <td>{{ $order->time_pick_up == "" ? '' : $order->time_pick_up }}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="font18">
                    <tbody>
                        <tr>
                            <td class="width80"><strong class="colortd">@lang('order.drop_off_date')</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong class="strongtds">@lang('order.date')</strong></td>
                            <td>{{ $order->drop_off_dates == "" ? trans('order.all_day') : $order->drop_off_dates }}</td>
                        </tr>
                        <tr>
                            <td><strong class="strongtds">@lang('order.time')</strong></td>
                            <td>{{ $order->time_drop_off == "" ? "" : $order->time_drop_off }}</td>
                        </tr>
                    </tbody>
                </table>
                @else
                    @lang('order.negotiate_with_mover')
                @endif

                
                <h4>
                <div class="width100">
                    <div class="fleft width40">
                        <img src="{{ URL::asset('/public/images/stehovani-predmetu.png')}}"/>     
                    </div>
                    <div class="fleft tupper">
                       &nbsp;@lang('order.items') <a class="colortd" href="" id="items_list_view_action">(@lang('order.view_the_list'))</a> 
                    </div>
                    <div style="clear:both;"></div>
                </div>
                </h4>

                <table class="font18">
                    <tbody>
                        <tr>
                            <td class="width80"><strong class="strongtds">@lang('order.small_items')</strong></td>
                            <td>{{ $order->small_items_amount() }}</td>
                        </tr>
                        <tr>
                            <td><strong class="strongtds">@lang('order.large_items')</strong></td>
                            <td>{{ $order->large_items_amount() }}</td>
                        </tr>
                    </tbody>
                </table>

                
                 <h4>
                <div class="width100">
                    <div class="fleft width40">
                        <img src="{{ URL::asset('/public/images/other-details.png')}}"/>    
                    </div>
                    <div class="fleft tupper">
                       &nbsp;@lang('order.other_details') 
                    </div>
                    <div style="clear:both;"></div>
                </div>
                </h4>

                <table class="font18">
                    <tbody>
                        <tr>
                            <td class="width80"><strong class="strongtds">@lang('order.number_of_helpers')</strong></td>
                            <td>{{ $order->helper_count }}</td>
                        </tr>
                        <tr>
                            <td><strong class="strongtds">@lang('order.assembly_dissasembly')</strong></td>
                            <td><?php  if($order->needAssembly()) { echo  '<img style="height:20px" src="'.URL::asset('/public/images/right.png').'"/>';}else {echo '<img  style="height:20px" src="'.URL::asset('/public/images/cross.png').'"/>'; } ?></td>
                        </tr>
                        <tr>
                            <td><strong class="strongtds">@lang('order.packing_needed')</strong></td>
                            <td><?php  if($order->needPackaging()) { echo  '<img style="height:20px" src="'.URL::asset('/public/images/right.png').'"/>';}else {echo '<img  style="height:20px" src="'.URL::asset('/public/images/cross.png').'"/>'; } ?></td>
                        </tr>
                    </tbody>
                </table>
                <h4>@lang('order.comments')</h4>
                <span>{{ $order->move_comments }}</span>

                <table class="font18">
                    <tbody>
                        <tr>
                            <td class="width80">
                                <strong class="strongtds">@lang('order.customer')</strong>
                                
                            </td>
                            <td>
                                <span class="colortds">{{ $order->getClient()->shortName }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
               <!--  <span class="colortd">{{ $order->getClient()->shortName }}</span> -->
            </div>
        </article>
        @if($order->isWon())
         
            @if(!Auth::user()->isMover())

                @include('elements.sidebars.provider')
            @else

                @include('elements.sidebars.client')
            @endif
        @else
            @include('elements.sidebars.bids')
        @endif
    </section>
</section>

<div id="items-box" class="hidden">

    @foreach($order->items()->get() as $item)
        <div class="row">
            <div class="col-xs-12">
                 {{$item->amount }} x {{ $item->name }}
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">

                @if($item->images()->first())
                    <img src="{{ URL::asset('public/uploads/items/'. $item->images()->first()->path) }}" style="width:150px !important;margin-top: 10px;margin-bottom: 10px;">
                @endif
            </div>

            <div class="col-xs-5">
                <div class="col-xs-12">@lang('order.size')</div>
                    <div class="col-xs-12">
                    @lang('order.assembly'): @if($item->assemb_dissasemb_need) @lang('order.yes') @else @lang('order.no') @endif
                    </div>
                    <div class="col-xs-12">
                    @lang('order.packaging'): @if($item->packaking_need) @lang('order.yes') @else @lang('order.no') @endif
                    </div>
                    <div class="col-xs-12 red">
                        @if(!$item->fit_to_elevator)
                            @lang('order.does_not_fit_elevator')
                        @endif
                    </div>
            </div>
        </div>

        <div class="hidden row">
            <div class="col-xs-12">
                {{ $item->description }}
            </div>
        </div>
        @if(next($item))
            <hr>
        @endif
    @endforeach
</div>

@endsection
