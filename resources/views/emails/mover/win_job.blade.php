@extends('emails.layouts.general')

@section('content')

Hi there,<br><br>

Congratulation, you have won job #{{ $job->id }}.<br><br>



<div><!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ URL::to('/orders/show/'.$job->order_id) }}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" strokecolor="#1e3650" fill="t">
    <v:fill type="tile" src="https://i.imgur.com/0xPEf.gif" color="#70c14a" />
    <w:anchorlock/>
    <center style="color:#ffffff;font-family:sans-serif;font-size:13px;font-weight:bold;">more information about the job</center>
  </v:roundrect>
<![endif]--><a href="{{ URL::to('/orders/show/'.$job->order_id) }}"
style="background-color:#70c14a;background-image:url(https://i.imgur.com/0xPEf.gif);border:1px solid #1e3650;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;mso-hide:all;">more information about the job</a></div>
<br><br>

Below you can find the contact details of the customer:<br><br>

{{ $job->order()->first()->user()->first()->full_name }}<br>
Phone number: {{ $job->order()->first()->user()->first()->phone_number }}<br>
Email: {{ $job->order()->first()->user()->first()->email }}<br>


We wish you a successful move.<br><br>

Kind regards,<br><br>

Thomas,<br>
Customer Happiness Engineer<br>
Teleportoo


@endsection