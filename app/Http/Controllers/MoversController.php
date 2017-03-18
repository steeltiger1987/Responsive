<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Image;
use App\Models\Insurance;
use App\Models\Order;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MoversController extends Controller
{

    public function deleteCar($id)
    {
        Car::destroy($id);
        return back();
    }

    public function carEdit($id)
    {
        $car = Car::find($id);

        return view('account.mover.edit_car')->with('car', $car);
    }

    public function updateCar($id, Request $request)
    {
        //Get existing car
        $car = Car::find($id);
        $car->fill($request->all());

        //Getting cars photo
        $file = $this->process_uploading($request->file('car_photo'), 'car');

        if ($file) {
            Image::where(['imagable_id' => $car->id, 'imagable_type' => Car::class, 'custom' => 'cars'])->delete();
            $imageObject = new Image();
            $imageObject->imagable_id = $car->id;
            $imageObject->imagable_type = Car::class;
            $imageObject->path = $file;
            $imageObject->custom = 'cars';
            $imageObject->save();
        }
        //Getting driver photo
        $file = $this->process_uploading(Input::file('car_driver_photo'), 'driver');

        if ($file) {
            Image::where(['imagable_id' => $car->id, 'imagable_type' => Car::class, 'custom' => 'driver'])->delete();
            $imageObject = new Image();
            $imageObject->imagable_id = $car->id;
            $imageObject->imagable_type = Car::class;
            $imageObject->path = $file;
            $imageObject->custom = 'driver';
            $imageObject->save();
        }

        $car->save();

        return redirect('/account');
    }

    public function addCarForm()
    {
        return view('account.mover.add_car');
    }

    public function showProfile($id, $order_id = null)
    {
        if ($order_id == null) {
            return view('elements.modals.mover_profile')->with(['user' => User::find($id), 'order' => null]);
        }

        return view('elements.modals.mover_profile')->with(['user' => User::find($id), 'order' => Order::find($order_id)]);
    }

    public function addCar(Request $request)
    {
        //Validates form result
        $this->validate($request, [
            'manufacturer'     => 'required',
            'model'            => 'required',
            'year'             => 'required|numeric',
            'loading_capacity' => 'required|numeric'
        ]);
        //Create new car
        $car = new Car();
        $car->fill($request->all());
        $car->user_id = $request->user()->id;
        $car->save();

        //Proceed car photo
        if ($file = $this->process_uploading($request->file('car_photo'), 'car')) {
            $imageObject = new Image();
            $imageObject->imagable_id = $car->id;
            $imageObject->imagable_type = Car::class;
            $imageObject->path = $file;
            $imageObject->custom = 'cars';
            $imageObject->save();
        }

        //Proceed driver photo
        if ($file = $this->process_uploading(Input::file('car_driver_photo'), 'driver')) {

            $imageObject = new Image();
            $imageObject->imagable_id = $car->id;
            $imageObject->imagable_type = Car::class;
            $imageObject->path = $file;
            $imageObject->custom = 'driver';
            $imageObject->save();
        }

        //Return with user
        return redirect('/account')->with('user', $request->user());
    }


    /**
     * Creates review
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function review(Request $request)
    {
        Rating::create($request->except('_token'));

        return response()->json(['response', true]);
    }

    public function showRegisterSecondStep()
    {
        return view('account.user.mover_register_step_2');
    }

    public function finishRegistration(Request $request)
    {
        $this->validate($request, [
            'manufacturer'     => 'required',
            'model'            => 'required',
            'year'             => 'required|numeric',
            'loading_capacity' => 'required|numeric',
            'insurance_value'  => 'numeric|required_with:is_insured'
        ]);

        $car = new Car();
        $car->fill($request->all());
        $car->user_id = $request->user()->id;
        $car->save();

        $file = $this->process_uploading($request->file('car_photo'), 'car');

        if ($file) {
            $imageObject = new Image();
            $imageObject->imagable_id = $car->id;
            $imageObject->imagable_type = Car::class;
            $imageObject->path = $file;
            $imageObject->custom = 'cars';
            $imageObject->save();
        }

        $file = $this->process_uploading(Input::file('car_driver_photo'), 'driver');

        if ($file) {
            $imageObject = new Image();
            $imageObject->imagable_id = $car->id;
            $imageObject->imagable_type = Car::class;
            $imageObject->path = $file;
            $imageObject->custom = 'driver';
            $imageObject->save();
        }

        //Adding insurance model

        if ($request->is_insured != 'on') {
            Insurance::create([
                'is_insured' => 0,
                'amount'     => 0,
                'user_id'    => $request->user()->id
            ]);
        } else {
            Insurance::create([
                'is_insured' => 1,
                'amount'     => $request->insurance_value,
                'user_id'    => $request->user()->id
            ]);
        }

        return redirect('/account')->with('user', $request->user());
    }

    private function process_uploading($file, $type)
    {
        $filename = "";
        if ($file == null) {
            return false;
        }
        $extension = $file->getClientOriginalExtension();
        $directory = public_path() . '/uploads/' . $type . '/';
        $filename = sha1(time() . time() . $type) . ".{$extension}";

        if ($file->move($directory, $filename)) {
            return $filename;
        } else {
            return false;
        }
    }

    public function activate($userId){
        $user = User::where('id', $userId)->first();
        $user->activateMover();
        return back()->with('mover', $user);
    }

    public function deactivate($userId){
        $user = User::where('id', $userId)->first();
        $user->deactivateMover();
        return back()->with('mover', $user);
    }

    public function updateComission(Request $request){

        $user = User::where('id', $request->userId)->first();
        $user->setComission($request->comission);

        return back()->with('mover', $user);
    }


}
