<?php

namespace App\Http\Controllers;


use App\Models\Admin\settings;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;


class AccountsController extends Controller
{

    protected function account(Request $request)
    {
        if ($request->user()->isMover()) {
            return view('account.mover.main')->with('user', $request->user());
        }

        return view('account.user.main')->with('user', $request->user());
    }

    protected function billingInfo(Request $request)
    {
        //Saving billing info
        if ($request->isMethod('post')) {

            $user = $request->user();

            $user->updateBillingInfo($request);
            $user->createBalance();

            session()->flash('flash_message', trans('account.info_successfully_saved'));

            if (session()->get('bidding_redirect')) {

                return redirect(url(session()->get('bidding_redirect')));
            }

            return back();
        }

        return view('account.user.billing')->with(['billingInfo' => $request->user()->billingInfo()->first(),
                                                   'bankAccount' => settings::where('name', 'bank-account')->first()->value,
                                                   'bankCode' => settings::where('name', 'bank-code')->first()->value]);
    }

    protected function billingInfoFirst(Request $request)
    {
        //Saving billing info
        if ($request->isMethod('post')) {

            $user = $request->user();

            $user->updateBillingInfo($request);
            $user->createBalance();

            session()->flash('flash_message', trans('account.info_successfully_saved'));

            if (session()->get('bidding_redirect')) {
                return redirect(url(session()->get('bidding_redirect')));
            }
            return redirect()->intended();
        }


        return view('account.user.billingFirst')->with(['billingInfo' => $request->user()->billingInfo()->first()]);
    }

    protected function personalDetailsForm()
    {
        return view('account.both.personal_details')->with('user', Auth::user());
    }

    protected function personalDetailsSave(Request $request)
    {

        if ($request->has('cancel')) {
            return redirect(url('/account'));
        }

        $user = Auth::user();

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        $user->save();

        $file = $this->process_uploading($request->file('mover_photo'), 'mover');

        if ($file) {
            Image::where(['imagable_id' => $user->id, 'imagable_type' => User::class])->delete();
            $imageObject = new Image();
            $imageObject->imagable_id = $user->id;
            $imageObject->imagable_type = User::class;
            $imageObject->path = $file;
            $imageObject->custom = '';
            $imageObject->save();
        }

        return redirect(url('/account'))->with('message', 'Successfully saved');
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
}
