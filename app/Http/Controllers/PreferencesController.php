<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferencesController extends Controller
{

    public function action(Request $request)
    {

        if ($request->cancel == 1) {
            return redirect(url('/account'));
        }

        Region::where('user_id', $request->user_id[0])->delete();

        for ($i = 0; $i < count($request->region_name); $i++) {
            Region::create([
                'region_name' => $request->region_name[$i],
                'user_id'     => $request->user_id[$i],
                'country'     => $request->country[$i],
                'identifier'  => $request->identifier[$i]
            ]);
        }

        if (count($request->country_delete) > 0) {

            for ($i = 0; $i < count($request->country_delete); $i++) {
                $region = new Region();
                Region::where('country', $region->getShortName($request->country_delete[$i]))->where('user_id', $request->user_id[0])->delete();
            }
        }

        return redirect(url('/account'));
    }

    public function removeRegion(Request $request)
    {
        return Region::where('identifier', $request->identifier)->where('user_id', $request->user_id)->delete();
    }

    public function addRegion(Request $request)
    {
        return Region::create($request->all());
    }

    public function home()
    {
        if (Auth::user()->isMover()) {
            return view('account.mover.preferences')->with(['regions' => Region::where('user_id', Auth::user()->id)->get(), 'countries' => Region::where('user_id', Auth::user()->id)->get()->groupBy('country')]);
        }

        return redirect('/account');
    }
}
