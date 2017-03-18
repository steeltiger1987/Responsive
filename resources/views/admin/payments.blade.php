@extends('layouts.admin')

@section('content')

    <div class="menu inline">
        <ul>
             <li><a href="{{ url("/export/payments") }}" class="btn small green">Export to excel</a></li>
        </ul>
    </div>

    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>User id</th>
                <th>Transaction id</th>
                <th>Done</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)

                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->currency }}</td>
                    <td>{{ $payment->getUserId() }}</td>
                    <td>{{ $payment->tid }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>

        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>User id</th>
                <th>Transaction id</th>
                <th>Done</th>
            </tr>
        </tfoot>
    </table>
@endsection