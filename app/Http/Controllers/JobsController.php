<?php

namespace App\Http\Controllers;

use App\Mail\Mover\WinJob;
use App\Mail\PickedMover;
use App\Models\Admin\settings;
use App\Models\Bid;
use App\Models\Job;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{

    protected function createJob(Request $request){
        //Create job
        $job = Job::create($request->all());
        //Mark order as disabled
        $order = Order::find($request->order_id);
        $order->assigned();

        //Charge commision for mover
        $mover = $job->getUser();

        $settings = settings::where('name', 'default-comission')->first();

        $mover->removeFunds($settings->value);

        //Send info to customer and mover
        Mail::to($job->getUser())
            ->queue(new WinJob($job));

        Mail::to($order->user()->first())
            ->queue(new PickedMover($job->getUser()));

        //Return view.
        return response()->json(['response' => true]);
    }

    protected function show($id = null){

        if(Auth::user()->isMover()){
            return view('account.mover.jobs')->with('jobs', Job::join('orders', 'orders.id', 'jobs.order_id')->where('jobs.user_id', Auth::user()->id)->orderBy('orders.pick_up_dates')->get());
        }

        return redirect('/account');
    }

    protected function reviewJob($job_id){
        return view('elements.modals.review')->with(['job' => Job::find($job_id)]);
    }

    protected function approveOrder($order_id, $user_id, $bid_id){
        return view('elements.modals.jog_accept_approval')->with(['order' => Order::find($order_id), 'mover' => User::find($user_id), 'bid' => Bid::find($bid_id)]);
    }

    protected function endJob($jobId){
        $job = Job::find($jobId);

        $job->order()->first()->setDone();

        return back();
    }

}
