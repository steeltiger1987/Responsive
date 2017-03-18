@extends('layouts.admin')

@section('content')

    <div class="menu inline">
            <ul>
                 <li><a href="{{ url("/export/orders") }}" class="btn small green">Export to excel</a></li>
            </ul>
        </div>

    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>When order was created</th>
                    <th>Pick up location</th>
                    <th>Drop off location</th>
                    <th>Scheduled pick up</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Customer phone</th>
                    <th>Mover</th>
                    <th>Mover phone</th>
                    <th>Payment method</th>
                    <th>Small items</th>
                    <th>Large items</th>
                    <th>Floor A</th>
                    <th>Floor B</th>
                    <th>Final price</th>
                    <th>Estimate duration</th>
                    <th>Rating by mover</th>
                    <th>Rating by customer</th>
                    <th>Helpers</th>
                    <th>Ridealong</th>
                    <th>Note C</th>
                    <th>Note M</th>
                    <th>Expires</th>
                    <th>Cancel</th>
                    <th>Notes</th>
                    <th>Add notes</th>
                </tr>
            </thead>
            <tbody>

            @foreach($orders as $order)

                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->pickup_address }}</td>
                        <td>{{ $order->drop_off_address }}</td>
                        <td>{{ ($order->pick_up_dates == "") ? "All day" : $order->pick_up_dates}}</td>
                        <td>{{ $order->status }}</td>
                        @if($order->user()->where('is_client', 1)->first() != null)
                        <td>{{ $order->user()->where('is_client', 1)->first()->full_name }}</td>
                        @else
                        <td>N/A</td>
                        @endif
                        <td>{{ $order->user()->where('is_client', 1)->first()->phone_number }}</td>
                        @if(!is_null($order->job()->first()))
                            <td>{{ $order->job()->first()->user()->first()->full_name }}</td>
                            <td>{{ $order->job()->first()->user()->first()->phone_number }}</td>
                        @else
                             <td>N/A</td>
                             <td>N/A</td>
                        @endif
                        <td>N/A</td>
                        <td>{{ $order->small_items_amount() }}</td>
                        <td>{{ $order->large_items_amount() }}</td>
                        <td>{{ $order->pickup_floor }}</td>
                        <td>{{ $order->drop_off_floor }}</td>
                        @if(!is_null($order->job()->first()))
                        <td> {{ $order->job()->first()->bid()->first()->bid }} </td>
                        @else
                        <td> N/A </td>
                        @endif
                        <td> {{ $order->old_time }} </td>
                        <td> N/A </td>
                        <td> N/A</td>
                        <td> {{ $order->helper_count }} </td>
                        <td> {{ $order->ride_along }} </td>
                        <td> N/A </td>
                        <td> {{ $order->move_comments }} </td>
                        <td> {{ $order->expiration_date }}</td>
                        <td> <a href="{{ url('/orders/cancel/'. $order->id) }}" class="btn small blue">@lang('sidebars.cancel')</a> </td>
                        <td> {{ $order->note }} </td>
                        <td><a href="{{ url('/admin/order/'. $order->id .'/note/edit') }}" class="btn small blue">Add note</a></td>
                    </tr>

            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Id</th>
                                        <th>When order was created</th>
                                        <th>Pick up location</th>
                                        <th>Drop off location</th>
                                        <th>Scheduled pick up</th>
                                        <th>Status</th>
                                        <th>Customer</th>
                                        <th>Customer phone</th>
                                        <th>Mover</th>
                                        <th>Mover phone</th>
                                        <th>Payment method</th>
                                        <th>Small items</th>
                                        <th>Large items</th>
                                        <th>Floor A</th>
                                        <th>Floor B</th>
                                        <th>Final price</th>
                                        <th>Estimate duration</th>
                                        <th>Rating by mover</th>
                                        <th>Rating by customer</th>
                                        <th>Helpers</th>
                                        <th>Ridealong</th>
                                        <th>Note C</th>
                                        <th>Note M</th>
                                        <th>Expires</th>
                                        <th>Cancel</th>
                                        <th>Notes</th>

                                        <th>Add notes</th>

                </tr>
            </tfoot>
        </table>
@endsection