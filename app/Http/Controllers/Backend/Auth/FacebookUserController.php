<?php

namespace App\Http\Controllers\Backend\Auth;

use App\User;
use Facebook\Facebook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class FacebookUserController extends Controller
{
    use AuthenticatesUsers;

    public function store(Facebook $fb) //method injection
    {
        // retrieve form input parameters
        $uid = Request::input('uid');
        $access_token = Request::input('access_token');
        $permissions = Request::input('permissions');

        // assuming we have a User model already set up for our database
        // and assuming facebook_id field to exist in users table in database



        $user = User::where('facebook_id', $uid)->first();
//        dd($user);
        if ($user) {
            Auth::login($user);
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Xin chào'
            ]);
        } else {
            $user = new User();
            $user->facebook_id = $uid;
            $user->save();
            // get long term access token for future use
            $oAuth2Client = $fb->getOAuth2Client();
            $user->access_token = $oAuth2Client->getLongLivedAccessToken($access_token)->getValue();
            $user->save();

            // assuming access_token field to exist in users table in database
//        dd($user);

            // set default access token for all future requests to Facebook API
//        $fb->setDefaultAccessToken($user->access_token);
            $fb->setDefaultAccessToken($user->access_token);
            // call api to retrieve person's public_profile details
            $fields = "id,cover,name,email,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified";
            $fb_user = $fb->get('/me?fields='.$fields)->getGraphPage();
            $user->name = $fb_user['name'];
            $user->email = $fb_user['email'];
            $user->password = Hash::make('123456');
            $user->save();
            Auth::login($user);
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Xin chào'
            ]);
        }
        return redirect()->route('admin.PublishPage.list');
    }
}
