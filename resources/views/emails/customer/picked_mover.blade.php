@extends('emails.layouts.general')

@section('content')

Hi there,<br><br>

Congratulation for pick a provider for your job.<br><br>

Below you can find the contact details for the provider:<br><br>

{{ $mover->full_name }}<br>
Phone number: {{ $mover->phone_number }}<br>
Email: {{ $mover->email }}<br><br>

The contact details you can also find at the specific job’s page.<br><br>

Please do not forget to leave a review in the end of the job to help others picking the right fit for them.<br><br>

We wish you a stress free move.<br><br>

Kind regards,<br><br>

Thomas,<br>
Customer Happiness Engineer<br>
Teleportoo

@endsection