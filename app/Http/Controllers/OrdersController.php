<?php

namespace App\Http\Controllers;

use App\Mail\Mover\NewJobPosted;
use App\Mail\NewProvider;
use App\Mail\WelcomeEmail;
use App\Models\Bid;
use App\Models\Image;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class OrdersController extends Controller
{
    /**
     * Retrieving view for creating order.
     * @param null $step
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if (!Auth::guest()) {
            if (Auth::user()->isMover()) {
                return redirect('account');
            }
        }

        //Creating first first object or update existing
        if ($request->isMethod('POST')) {
            $this->updateEstimateTime($request);
            $this->updateOrCreateOrder($request);
        }

        /**
         * Depending on step do validation and return view.
         */
        return $this->step($request);
    }

    private function updateEstimateTime(Request $request)
    {
        if (!$request->session()->exists('time-elapsed')) {
            $request->session()->put('time-elapsed', $request['old_time']);
        }

        if ($request->has('old_time')) {
            $request->session()->put('time-elapsed', $request['old_time']);
        }
    }


    /**
     * Makes logic for step
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    private function step($request)
    {
        $step = $request->get('step');

        if ($step == null) {
            session()->forget('order');
            session()->forget('time-elapsed');

            $from = '';
            $to = '';

            if($request['order-from'] != null){
                $from = $request['order-from'];
            }

            if($request['order-to'] != null){
                $to = $request['order-to'];
            }

            return view('order.addresses', ['next_step' => 'items', 'active' => 'address', 'old_time' => '0', 'fields' => $this->addressFields(), 'from' => $from, 'to' => $to]);
        }

        if ($step == 'address') {
            return view('order.addresses', ['next_step' => 'items', 'active' => 'address', 'old_time' => '0', 'fields' => $this->addressFields()]);
        }

        if ($step == 'items') {
            if ($request->isMethod('POST')) {
                $this->validate($request, [
                    'pickup_address'    => 'required',
                    'pickup_floor'      => 'required',
                    'pickup_elevator'   => 'required',
                    'drop_off_floor'    => 'required',
                    'drop_off_address'  => 'required',
                    'drop_off_elevator' => 'required',
                ]);
            }

            return view('order.items', ['next_step' => 'dates', 'active' => 'items', 'old_time' => $request->old_time, 'fields' => $this->itemsFields()]);
        }

        if ($step == 'dates') {
            if ($request->isMethod('POST')) {

                $order = $request->session()->get('order');

                $itemsCount = 0;
                if ($order != null) {
                    $itemsCount = count($order->items()->get());
                }

                if ($itemsCount == 0) {
                    $this->validate($request, [
                        'items_count' => 'min:1|required'
                    ]);
                }


                if (Input::has('will_help') && Input::has('helper_count')) {
                    $this->updateOrCreateOrder($request);
                }
            }

            if (!Auth::guest()) {
                return view('order.dates', ['next_step' => 'finish', 'active' => 'finish', 'old_time' => null, 'fields' => $this->datesFields()]);
            }

            return view('order.dates', ['next_step' => 'account', 'active' => 'dates', 'old_time' => $request->old_time, 'fields' => $this->datesFields()]);
        }

        if ($step == 'account') {
            if ($request->isMethod('POST')) {

                $this->validate($request, [
                    'pick_up_interval'       => 'required_without:negotiate_by_self',
                    'drop_off_interval'      => 'required_without:negotiate_by_self',
                    'expiration_date'        => 'required|after:-1 days',
                    'time_pick_up_interval'  => 'required_with:interval',
                    'time_drop_off_interval' => 'required_with:interval-drop-off',
                    'time_pick_up'           => 'required_with:exact-time-pick-up-checkbox',
                    'time_drop_off'          => 'required_with:exact-time-drop-off-checkbox'
                ]);

                $this->updateOrCreateOrder($request);
            }
            return view('order.account', ['next_step' => 'finish', 'active' => 'account', 'old_time' => $request->old_time]);
        }

        if ($step == 'finish') {
            $existing_user = false;
            if (Auth::guest()) {
                $this->validate($request, [
                    'name'       => 'required|max:255',
                    'email'      => 'required|email|max:255|unique:users',
                    'password'   => 'required|min:6|confirmed',
                    'aggreement' => 'required'
                ]);
            } else {
                $existing_user = true;
                $this->validate($request, [
                    'pick_up_interval'       => 'required_without:negotiate_by_self',
                    'drop_off_interval'      => 'required_without:negotiate_by_self',
                    'expiration_date'        => 'required|after:yestarday',
                    'time_pick_up_interval'  => 'required_with:interval',
                    'time_drop_off_interval' => 'required_with:interval-drop-off',
                    'time_pick_up'           => 'required_with:exact-time-pick-up-checkbox',
                    'time_drop_off'          => 'required_with:exact-time-drop-off-checkbox',
                ]);
            }


            if ($request->isMethod('POST') && Auth::guest()) {
                $user = new User();

                $user->fill([
                    'name'         => $request->name,
                    'last_name'    => $request->last_name,
                    'email'        => $request->email,
                    'phone_number' => $request->phone_number,
                    'password'     => bcrypt($request->password),
                    'is_client'    => 1,
                    'is_mover'     => 0
                ]);
                
                $user->getVariable();

                $user->save();
                $user->createOrder($this->getOrder($request));

                //Sending welcome email to user
                Mail::to($user)->send(new WelcomeEmail());
            } else {
                $request->user()->createOrder($this->getOrder($request));
                //Sending welcome email to user
                Mail::to($request->user())->send(new WelcomeEmail());
            }

            if (Auth::guest()) {
                Auth::guard()->login($user);
            }

            //Send to all movers with queue about order created

            foreach (User::where('is_mover', 1)->get() as $mover) {
                Mail::to($mover)
                    ->queue(new NewJobPosted($this->getOrder($request)));
            }
            if ($existing_user) {
                return redirect('/orders/show');
            }

            return view('order.finish', ['next_step' => null, 'active' => 'finish', 'old_time' => null]);
        }
    }

    protected function prolongOrder($id)
    {
        $order = Order::find($id);

        if($order->isWon()){
            return back();
        }

        if (!$order) {
            return 'Order not found';
        }

        return view('elements.modals.prolong', ['order' => $order]);
    }

    protected function cancelOrder($id)
    {
        $order = Order::find($id);

        if($order->isWon()){
            return back();
        }

        if (!$order) {
            if(Auth::user()->isAdmin()){
                return redirect(url('admin/orders-list'));
            }
            return redirect(url('/orders/show'));
        }

        $order->delete();

        if(Auth::user()->isAdmin()){
            return redirect(url('admin/orders-list'));
        }

        return redirect('/orders/show');
    }

    protected function show(Request $request, $id = null)
    {

        if ($id) {

            $order = Order::find($id);

            if ($order->isWon()) {

                if(Auth::user()->id == $order->job()->first()->user()->first()->id && Auth::user()->isMover()){

                    return view('order.show')->with(['order' => $order, 'mover' => 'nothing']);
                }

                if(Auth::user()->isUser()){
                    return view('order.show')->with(['order' => $order, 'mover' => 'nothing']);
                }

                return redirect('/orders/show');
            }
            
            return view('order.show')->with(['order' => $order]);
        }

        if ($request->user()->isMover()) {
            if (Auth::user()->hasSetPreferences()) {
                return view('order.show_all_mover')->with(['needPreferences' => false, 'orders' => Order::getByRegion(Auth::user()->id)]);
            }

            return view('order.show_all_mover')->with(['needPreferences' => true, 'orders' => Order::getByRegion(Auth::user()->id)]);
        }


        //Shows only orders that were created by client
        return view('order.show_all_customer')->with(['orders' => $request->user()->orders()->get()]);
    }

    protected function itemsModal($id = null)
    {
        if ($id == null) {
            return view('elements.modals.create_item_modal');
        }

        return view('elements.modals.update_item_modal')->with('item', Item::find($id));
    }

    protected function showBidForm(Request $request, $id)
    {
        if (!$request->user()->cars()->get()) {
            return back()->withErrors(['msg', 'You dont have cars']);
        }

        return view('order.add_bid')->with(['user' => $request->user(), 'order' => Order::find($id), 'currency' => currency()->getUserCurrency()]);
    }

    protected function editBid(Request $request, $id)
    {
        $bid = Bid::find($id);

        if($bid->order()->first()->isWon()){
            return back();
        }

        if ($bid != null) {
            if ($request->isMethod('POST')) {
                $bid->bid = $request->bid;
                $bid->car_id = $request->car_id;
                if ($request->ride_along != null) {
                    $bid->ride_along = $request->ride_along;
                }

                if ($request->ride_along_client != null) {
                    $bid->ride_along_client = $request->ride_along_client;
                }

                if ($request->movers != null) {
                    $bid->movers = $request->movers;
                }

                if ($request->movers_count != null) {
                    $bid->movers_count = $request->movers_count;
                }

                if ($request->spolumoving != null) {
                    $bid->spolumoving = $request->spolumoving;
                }

                $bid->save();

                return redirect('/orders/show/' . $bid->order_id);
            }

            return view('order.edit_bid')->with(['bid' => $bid, 'user' => User::find($bid->user_id), 'currency' => currency()->getUserCurrency()]);
        }

        return back()->withErrors(['msg', 'There are no bid']);
    }

    protected function makeBid(Request $request)
    {
        $this->validate($request, [
            'bid' => 'required|numeric',
        ]);

        $bid = Bid::create($request->all());

        session()->flash('flash_message', 'You have successfully bidded');

        //Send info to user

        $order = Order::find($request->order_id);

        $user = User::find($order->user_id);
        $mover = User::find($request->user_id);

        if ($user && $mover && $order) {
            Mail::to(User::find($order->user_id))->send(new NewProvider(User::find($request->user_id), $bid));
        }

        return redirect('/orders/show/' . $order->id)->with('order', $order);
    }

    /**
     * AJAX calls
     */

    public function getItemsAjax($orderId)
    {
        $items = [];

        $items['small_items'] = Item::where('type', 'small')->where('order_id', $orderId)->get();
        $items['large_items'] = Item::where('type', 'large')->where('order_id', $orderId)->get();

        return response()->json($items);
    }

    public function createItemAjax(Request $request)
    {
        //Create
        $order = $request->session()->get('order');

        if (Input::has('id')) {
            $item = Item::find(Input::get('id'));
        } else {
            $item = new Item;
        }


        $item->fill($request->all());
        $item->order_id = $order->id;
        $item->save();

        //Adding images to item
        if (Input::has('images')) {
            foreach (Input::get('images') as $image) {
                $imageObject = new Image();
                $imageObject->imagable_id = $item->id;
                $imageObject->imagable_type = Item::class;
                $imageObject->path = $image;
                $imageObject->save();
            }
        }

        //Return json response
        return response()->json(['response' => true, 'data' => ['message' => 'Success!', 'item' => $item->toArray()]]);
    }

    protected function deleteItemAjax($item_id)
    {

        $item = Item::find($item_id);
        $order = $item->order_id;
        $item->delete();

        return response()->json(['response' => true, 'data' => ['order_id' => $order]]);
    }

    protected function updateExpiration(Request $request)
    {
        $order = Order::find($request->order_id);

        $order->expiration_date = $request->expiration_date;
        $order->save();

        return response()->json(['response' => true]);
    }


    public function uploadFileAjax()
    {
        $input = Input::all();
        $rules = array(
            'file' => 'image',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

        $file = Input::file('file');

        $extension = $file->getClientOriginalExtension();
        $directory = public_path() . '/uploads/items/';
        $filename = sha1(time() . time()) . ".{$extension}";

        $upload_success = $file->move($directory, $filename);


        if ($upload_success) {
            return Response::json($filename, 200);
        } else {
            return Response::json('error', 400);
        }
    }

    private function updateOrCreateOrder(Request $request)
    {
        if(isset($request['order-from']) && isset($request['order-to'])){
            return false;
        }
        if (!$request->session()->exists('order')) {
            $order = Order::create($request->all());
            $request->session()->put('order', $order);
            $order->old_time = $request->session()->get('time-elapsed');
            $order->save();
        }

        $request->session()->get('order')->update($request->all());
    }

    private function getOrder(Request $request)
    {
        return $request->session()->get('order');
    }

    private function addressFields()
    {
        if (session()->has('order')) {
            $order = session()->get('order');
        } else {
            return [
                'pickup_address'    => '',
                'drop_off_address'  => '',
                'pickup_floor'      => 0,
                'pickup_elevator'   => false,
                'drop_off_floor'    => 0,
                'drop_off_elevator' => false,
            ];
        }

        return [
            'pickup_address'    => $order->pickup_address,
            'drop_off_address'  => $order->drop_off_address,
            'pickup_floor'      => $order->pickup_floor,
            'pickup_elevator'   => $order->pickup_elevator,
            'drop_off_floor'    => $order->drop_off_floor,
            'drop_off_elevator' => $order->drop_off_elevator,
        ];
    }

    private function itemsFields()
    {
        if (session()->has('order')) {
            $order = session()->get('order');
        } else {
            return [
                'small_items'   => array(),
                'large_items'   => array(),
                'move_comments' => ''
            ];
        }

        return [
            'small_items'   => Item::where('type', 'small')->where('order_id', $order->id)->get(),
            'large_items'   => Item::where('type', 'large')->where('order_id', $order->id)->get(),
            'move_comments' => $order->move_comments
        ];
    }

    private function datesFields()
    {
        if (session()->has('order')) {
            $order = session()->get('order');
        } else {
            return [
                'pick_up_interval'  => '',
                'drop_off_interval' => ''
            ];
        }

        return [
            'pick_up_interval'  => $order->time_pick_up_interval,
            'drop_off_interval' => $order->time_drop_off_interval
        ];
    }

    protected function cancelBid($bid_id)
    {


        $bid = Bid::where('id', $bid_id);

        if($bid->order()->first()->isWon()){
            return back();
        }

        $bid->delete();

        return redirect('/orders/show/');
    }


}
