<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Mail\Mover\TopedUp;
use App\Models\Admin\settings;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use League\Csv\Reader;
use League\Csv\Statement;




class IndexController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    protected function index(Request $request)
    {
        if (Auth::check()) {
            return view('admin.index');
        }
        return $this->showLoginForm($request);
    }

    protected function customers_list(Request $request)
    {
        return view('admin.customers_list')->with('users', User::where('is_client', 1)->with('orders')->get());
    }

    protected function orders_list(Request $request)
    {
        return view('admin.orders_list')->with('orders', Order::where('user_id', '>', 0)->get());
    }

    protected function movers_list(Request $request)
    {
        return view('admin.movers_list')->with('users', User::where('is_mover', 1)->with(['jobs'])->get());
    }

    protected function payments(Request $request)
    {
        return view('admin.payments')->with('payments', Payment::all());
    }

    protected function showMover($id){

        if(User::where('id', $id)->first() == null){
            return back();
        }

        return view('admin.mover')->with('mover', User::where('id', $id)->first());
    }

    protected function settings(Request $request)
    {
        $settings = settings::all();

        $settings_array = array();
        foreach ($settings as $setting) {
            $settings_array[$setting->name] = $setting->value;
        }
        return view('admin.settings')->with('settings', $settings_array);
    }

    protected function settingsSave(Request $request)
    {
        $setting = settings::where('name', 'bank-account')->first();
        $setting->value = $request->bank_account;
        $setting->save();

        $setting = settings::where('name', 'bank-code')->first();
        $setting->value = $request->bank_code;
        $setting->save();

        $setting = settings::where('name', 'default-comission')->first();
        $setting->value = $request->default_comission;
        $setting->save();

        return redirect('/admin/settings');
    }

    protected function topUp()
    {
        return view('admin.topup_form')->with('users', User::where('is_mover', '1')->get());
    }

    protected function makePayment(Request $request)
    {
        //Create payment
        $payment = Payment::create([
            'type'      => 'top-up',
            'amount'    => $request->amount,
            'currency'  => 'CZK',
            'reference' => 'user_' . $request->user_id,
            'result'    => 0,
            'tid'       => str_random(40),
            'oid'       => 0
        ]);

        //Add money to users balance
        $userId = $request->user_id;
        $user = User::find($userId);
        $user->addFunds($payment->amount);

        //Send email
        Mail::to($user)->send(new TopedUp($user, $payment));

        return redirect('/admin/payments');
    }

    protected function showNoteForm($order_id){
        return view('admin.note')->with('order', Order::where('id', $order_id)->first());
    }

    protected function storeNote($order_id, Request $request){
        $order = Order::where('id', $order_id)->first();

        $order->note = $request->note;

        $order->save();

        return redirect(url('/admin/orders-list'));

    }


    protected function test(){
        //load the CSV document
        $csv = Reader::createFromPath('app/file.csv')
            ->setHeaderOffset(0)
            ->addStreamFilter('convert.iconv.ISO-8859-1/UTF-8')
        ;

//build a statement
        $stmt = (new Statement())
            ->offset(0)
            ->limit(100)
        ;

//query your records from the document
        $records = $stmt->process($csv)->fetchAll();

        dd($records);
    }






}
