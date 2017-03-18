<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Mover\WelcomeEmail;
use App\Models\Admin\settings;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create($data)
    {
        
        $user = new User();
        
       
        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->phone_number = $data['phone_number'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->is_client = $data['is_client'];
        $user->is_mover = $data['is_mover'];

        $user->base_address = '';
        if(isset($data['base_address'])){
            $user->base_address = $data['base_address'];
        }

        $settings = settings::where('name', 'default-comission')->first();
        $user->comission = $settings->value;
       
        $user->getVariable();
        $user->save();
        

        //Send welcome email
        if($user->isMover()){
            Mail::to($user)->send(new WelcomeEmail());
        } else {
            Mail::to($user)->send(new \App\Mail\WelcomeEmail());
        }

        return $user;
    }

    protected function showSelectPage(){
        return view('auth.select_registration');
    }

    protected function showForm(Request $request){
        if($request->is('client/register')){

            return view('auth.register_user');
        }

        return view('auth.register_mover');

    }
}
