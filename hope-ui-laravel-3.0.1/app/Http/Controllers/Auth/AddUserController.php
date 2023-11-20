<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegistrationConfirm;

class AddUserController extends Controller
{
    //
    public function store(Request $request)
    {
        $existingUser = User::where('username', $request->username)->first();
         if ($existingUser) {
        return redirect()->back()->with('error', 'This username is already registered. Please choose a different one.');
        }else{
        $user = new User;
        $user->username = strtolower($request->first_name).strtolower($request->last_name);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->company_name = $request->company_name;
        $user->street_addr_1 = $request->street_addr_1;
        $user->street_addr_2 = $request->street_addr_2;
        $user->country = $request->country;
        $user->alt_phone_number = $request->alt_phone_number;
        $user->pin_code = $request->pin_code;
        $user->city = $request->city;
        $user->password = Hash::make($request->password);
        $user->user_type = 'user';
        $user->save();
        return redirect('/users');
        }
    }
}
