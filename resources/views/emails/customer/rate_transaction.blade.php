@extends('emails.layouts.general')

@section('content')

Hi there,

Please do not forget the rate the transaction.

<div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ URL::to('/orders/show/'.$order->id) }}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" strokecolor="#1e3650" fill="t">
    <v:fill type="tile" src="https://i.imgur.com/0xPEf.gif" color="#70c14a" />
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:sans-serif;font-size:13px;font-weight:bold;">Rate the transaction</center>
  </v:roundrect>
<![endif]--><a href="{{ URL::to('/orders/show/'.$order->id) }}"
style="background-color:#70c14a;background-image:url(https://i.imgur.com/0xPEf.gif);border:1px solid #1e3650;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">Rate the transaction</a></div>

We hope your job has been successful.

Kind regards,

Thomas,
Customer Happiness Engineer
Teleportoo

@endsection