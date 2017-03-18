@extends('emails.layouts.general')

@section('content')

Hi there,<br><br>

There is a new job post, which you might like:<br><br>

Addresses:<br>
A: {{ $order->pickup_address }} <br>
B: {{ $order->drop_off_address }}
<br><br>
Dates:<br>
@if($order->pick_up_dates != "" && $order->drop_off_dates != "")
    Pick up: {{ $order->pick_up_dates }}<br>
    Drop off: {{ $order->drop_off_dates }}
@else
    Negotiate with mover
@endif

<br><br>
Auction expires {{ $order->expiration_date }}.<br><br>


<div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ URL::to('/orders/show/'.$order->id) }}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" strokecolor="#1e3650" fill="t">
    <v:fill type="tile" src="https://i.imgur.com/0xPEf.gif" color="#70c14a" />
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:sans-serif;font-size:13px;font-weight:bold;">More details about  the job</center>
  </v:roundrect>
<![endif]--><a href="{{ URL::to('/orders/show/'.$order->id) }}"
style="background-color:#70c14a;background-image:url(https://i.imgur.com/0xPEf.gif);border:1px solid #1e3650;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">More details about  the job</a></div>
<br><br>

If you like the job, do not hesitate to bid on it asap.<br><br>

Kind regards,<br><br>

Thomas,<br>
Customer Happiness Engineer<br>
Teleportoo<br>


@endsection