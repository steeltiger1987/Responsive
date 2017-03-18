@extends('layouts.admin')
@inject('order', 'App\Models\Order')
@section('content')

    <div class="menu inline">
        <ul>
            <li><a href="{{ url('/admin/account/mover/topup') }}" class="btn small green">Top up customer</a></li>
             <li><a href="{{ url("/export/movers") }}" class="btn small green">Export to excel</a></li>
        </ul>
    </div>

    <div class="row">
    <div class="col-lg-12 col-mg-12">
            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Approved</th>
                        <th>Base</th>
                        <th>Total Jobs</th>
                        <th>Total bids</th>
                        <th>Job sees</th>
                        <th>Registered</th>
                        <th>Comission</th>
                        <th>Credits</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="{{ url('/admin/mover/'.$user->id) }}">{{ $user->full_name }}</a></td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->isActivated() ? 'Approved' : 'Not approved' }}</td>
                            <td>{{ $user->base_address }}</td>
                            <td>{{ count($user->jobs()->get()) }}</td>
                            <td>{{ $user->getAllBidsThatAreMade() }}</td>
                            <td>{{ count($order::getByRegion($user->id)) }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->comission }}</td>
                            <td>{{ $user->getBalance() }}</td>
                        </tr>

                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Approved</th>
                        <th>Base</th>
                        <th>Total Jobs</th>
                        <th>Total bids</th>
                        <th>Job sees</th>
                        <th>Registered</th>
                        <th>Comissions</th>
                        <th>Credits</th>
                    </tr>
                </tfoot>
            </table>
        </div>



    </div>

@endsection