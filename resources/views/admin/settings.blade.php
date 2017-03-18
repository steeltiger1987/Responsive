@extends('layouts.admin')

@section('content')

    <form method="POST" action="{{ url('/admin/settings/save') }}">
    {{ csrf_field() }}
      <div class="form-group">
        <label for="bank_account">Bank account:</label>
        <input type="text" class="form-control" name="bank_account" id="bank_account" value="{{ $settings['bank-account'] }}">
      </div>
      <div class="form-group">
          <label for="bank_code">Bank code:</label>
          <input type="text" class="form-control" name="bank_code" id="bank_code" value="{{ $settings['bank-code'] }}">
        </div>
    <div class="form-group">
        <label for="default_comission">Default comission:</label>
        <input type="text" class="form-control" name="default_comission" id="default_comission" value="{{ $settings['default-comission'] }}">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>

@endsection