@extends('emails.layouts.general')

@section('content')

Hi there,<br><br>

A new provider have gave a quote for your specified job.<br><br>

<div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ URL::to('/orders/show/'.$bid->order_id) }}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" strokecolor="#1e3650" fill="t">
    <v:fill type="tile" src="https://i.imgur.com/0xPEf.gif" color="#70c14a" />
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:sans-serif;font-size:13px;font-weight:bold;">Check out the bids</center>
  </v:roundrect>
<![endif]--><a href="{{ URL::to('/orders/show/'.$bid->order_id) }}"
style="background-color:#70c14a;background-image:url(https://i.imgur.com/0xPEf.gif);border:1px solid #1e3650;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">Check out the bids</a></div>
<br><br>
When you are ready and see a provider you like do not hesitate to select them.<br><br>

Kind regards,<br><br>

Thomas,<br>
Customer Happiness Engineer<br>
Teleportoo<br>

@endsection