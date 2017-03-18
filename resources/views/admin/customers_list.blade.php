@extends('layouts.admin')

@section('content')

    <!-- Adding post data for exporting. see js and /excel/index.php -->
    <script>
        var post_data = {person: { name: "John", age: 27 }};
    </script>
    <div class="menu inline">
            <ul>
                 <li><a href="{{ url("/export/customers") }}" class="btn small green">Export to excel</a></li>
            </ul>
        </div>

    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email address</th>
                <th>Spent</th>
                <th>Orders</th>
                <th>Rating</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)

                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->email }}</td>
                    <td>N/A</td>
                    <td>{{ count($user->orders()->get()) }}</td>
                    <td>N/A</td>
                    <td>{{ $user->created_at }}</td>
                </tr>

        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email address</th>
                <th>Spent</th>
                <th>Orders</th>
                <th>Rating</th>
                <th>Registered</th>
            </tr>
        </tfoot>
    </table>
@endsection