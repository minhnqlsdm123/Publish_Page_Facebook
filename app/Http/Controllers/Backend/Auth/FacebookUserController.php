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

//        $auth_user = Socialite::driver('facebook')->user();

        // assuming we have a User model already set up for our database
        // and assuming facebook_id field to exist in users table in database
        $user = User::firstOrCreate(['facebook_id' => $uid]);

        // get long term access token for future use
        $oAuth2Client = $fb->getOAuth2Client();

        // assuming access_token field to exist in users table in database
        $user->access_token = $oAuth2Client->getLongLivedAccessToken($access_token)->getValue();
//        dd($user);
        $user->save();

        // set default access token for all future requests to Facebook API
        $fb->setDefaultAccessToken($user->access_token);

        // call api to retrieve person's public_profile details
        $fields = "id,cover,name,email,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified";
        $fb_user = $fb->get('/me?fields='.$fields)->getGraphPage();
        if (!$user['name']) {
            $user['name'] = $fb_user['name'];
        }
        if (!$user['email']) {
            $user['email'] = $fb_user['email'];
        }
        $user_name = explode('@',  $user->email)[0];
        if(!$user['password']) {
            $user['password'] = hash::make($user_name);
        }
        $user->save();
        $data = [
            'email' => $user['email'],
            'password' => $user['password'],
        ];
        if ($user->facebook_id) {
            Auth::login($user);
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Xin chào'
            ]);
//            return redirect()->route('admin.product.list', $user);
            return view('backend.product.index', ['user' => $user]);

        } else {
            \Session::flash('toastr', [
                'type' => 'error',
                'message' => 'Thông tin đăng nhập chưa đúng'
            ]);
            return redirect()->back()->withInput();
        }
//        dd($user);

//        dump($fb_user);
//        dd(env('FACEBOOK_APP_ID'));

//        dd($fb_user);
//        $page = $fb->get('/100018164500336/accounts?access_token= '.$user->access_token);

//        dd($fb_page);
//        if ($fb_user) {
//        $page_id = '1943970019218960';
//        $params['mesasge'] = 'hello';
////        $response = $fb->post(
////            '/'.$page_id.'/',
//            array (
//                'message' => 'This is a test value',
//            ),
//            'EAAFPjYRzylgBADrWpZAJjDjAPvJtjqXhZCeYquAbK1gjGiXsUMZAPgZBg6T3trYDWu5WqZCMuRkhBanASDXbNr3HOZCg2OZBpY5xY2UgFhuWeggOuL4htpFObblH4L1Wmz4FwDvgkf1d2fM7Oqjv5B3buGAntZC');
//        dd($fb_page->getAccessToken());
        //return redirect()->route('admin.dasboard');
//        $data['message'] = "test nào dfgfdg";
////        $data['caption'] = "Caption";
////        $data['description'] = "Description";
//        $data['access_token'] = 'EAAFPjYRzylgBABR8hOXGJgNYQYAOcez6QHEeia2A1RCC8RCfJaaFbpUQEF84i3nVfwpzlUwWs7YiLTRzoZB9JDmZCn6Do9ZCi857OImQZAmRleJlC6xGSOwqlswhG28hJP762D2KB2Gq8lkz7pXqzrHD00ZCW9qftnEFM5CUQ1AXfsKhp43CKWMspjdVtt2UTVah35EHf7k5t3eu4lcz8fTEDhP3JUBoZD';
//        $post_url = 'https://graph.facebook.com/'.$page_id.'/feed';
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $post_url);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $return = curl_exec($ch);
//        dd($return);
//        curl_close($ch);
//        }
    }
}
