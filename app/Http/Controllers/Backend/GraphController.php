<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestCategory;
use App\Http\Requests\AdminRequestPublishPage;
use App\Models\Category;
use Carbon\Carbon;
use Facebook\Facebook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class GraphController extends Controller
{
    private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
//            dd(Auth::user());
//            $fb->setDefaultAccessToken(Auth::user()->token);
            $fb->setDefaultAccessToken(Auth::user()['access_token']);
//            dd(Auth::user());
            $this->api = $fb;
            return $next($request);
        });
    }

    public function retrieveUserProfile(){
        try {

            $params = "first_name,last_name,age_range,gender";

            $user = $this->api->get('/me?fields='.$params)->getGraphUser();

            dd($user);

        } catch (FacebookSDKException $e) {

        }

    }

    public function publishToProfile(Request $request){
        try {
            $response = $this->api->post('/me/feed', [
                'message' => $request->message
            ])->getGraphNode()->asArray();
            if($response['id']){
                // post created
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function getPageAccessToken(){
        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $page_id = '1943970019218960';
            $response = $this->api->get('/me/accounts', Auth::user()->access_token);
//            dd($response);
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        try {
            $pages = $response->getGraphEdge()->asArray();
            foreach ($pages as $key) {
                if ($key['id'] == $page_id) {
                    return $key['access_token'];
                }
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }

    public function getAdd()
    {
        return view('backend.PublishPage.add');
    }

    public function getPostPage() {
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $posts = $this->api->get('/' . $page_id . '/feed', $access_token);
        $posts = $posts->getGraphEdge()->asArray();
//        dd($posts);
        return view('backend.PublishPage.index', ['posts' => $posts]);

    }

    public function getDetailPostPage($id) {
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $post = $this->api->get('/' . $id , $access_token);
        $post = $post->getGraphNode()->asArray();
//        dd($post);
        return view('backend.PublishPage.update', ['post' => $post]);

    }


    public function publishPage(AdminRequestPublishPage $request) {

//        dd($request->all());
        $data = [];
        $data['message'] = $request->message;
        $data['photos'] = $request->image_detail;
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
//
//        foreach ($data['photos'] as $key => $item) {
//            dd($this->api->fileToUpload('http://localhost'.$item));
//            $uploadImage[$key] = $this->api->post('/'.$page_id.'/photos', ['publish' => 'false', 'source' => $this->api->fileToUpload('http://localhost'.$item)], $access_token);
////            dd($uploadImage[$key]);
//            $uploadImage[$key] = $uploadImage[$key]->getGraphNode()->asArray();
//            $image[$key] = $uploadImage[$key]['id'];
//        }
//        dd($data);
        \Session::flash('toastr', [
            'type' => 'success',
            'message' => 'Thêm thành công'
        ]);
        $post = $this->api->post('/' . $page_id . '/feed', array('message' => $data['message']), $access_token);
//        $post = $this->api->get('/' . $page_id . '/feed', $access_token);
        $post = $post->getGraphNode()->asArray();
//        dd($post);
//        $category->save();


        return redirect()->route('admin.PublishPage.list');
    }

    public function updatePostPage(AdminRequestPublishPage $request, $id) {
        $data = [];
        $data['message'] = $request->message;
        $data['post_id'] = $id;
//        dd($data);
        \Session::flash('toastr', [
            'type' => 'success',
            'message' => 'Cập nhật thành công'
        ]);
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $post = $this->api->post('/' . $data['post_id'], array('message' => $data['message']), $access_token);
//        $post = $this->api->get('/' . $page_id . '/feed', $access_token);
        $post = $post->getGraphNode()->asArray();
//        dd($post);
//        $category->save();


        return redirect()->route('admin.PublishPage.list');
    }
}
