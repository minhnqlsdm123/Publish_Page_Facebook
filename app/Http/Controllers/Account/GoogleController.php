<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Account;

class GoogleController extends Controller
{
    public function __construct()
    {
        
    }

    public function redirectToGoogle ()
    {
        //return Socialite::driver('google')->redirect();

    }

    public function handleGoogleCallback ()
    {
        // try {
    
        //     $user = Socialite::driver('google')->user();
     
        //     $finduser = Account::where('google_id', $user->id)->first();
     
        //     if($finduser){
     
        //         Auth::login($finduser);
    
        //         return redirect('/home');
     
        //     }else{
        //         $newUser = Account::create([
        //             'name' => $user->name,
        //             'email' => $user->email,
        //             'google_id'=> $user->id,
        //             'password' => encrypt('123456dummy')
        //         ]);
    
        //         Auth::login($newUser);
     
        //         return redirect('/frontend/home');
        //     }
    
        // } catch (Exception $e) {
        //     dd($e->getMessage());
        // }

    }
}
