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
use Yajra\DataTables\Contracts\DataTable;

class GraphController extends Controller
{
    private $api;
    public function __construct(Facebook $fb)
    {
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()['access_token']);
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

    public function getPageId() {
        $test = $this->api->get('/'.Auth::user()->facebook_id.'/accounts', Auth::user()->access_token);
        $test = $test->getGraphEdge()->asArray();
        dd($test);
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
        return view('backend.PublishPage.index', ['posts' => $posts]);

//        return view('backend.PublishPage.index');

    }

    public function anyData()
    {
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $posts = $this->api->get('/' . $page_id . '/feed', $access_token);
        $posts = $posts->getGraphEdge()->asArray();
//        $link= "route('admin.PublishPage.update',".$post['id'].")";

//        dd($posts);
        return datatables()->of($posts)
            ->make(true);

//            ->addColumn('action',function($post) {
//                return '<a href="/admin/page/" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Sửa </a>';
//            })
//            ->make(true);
    }

    public function getDetailPostPage($id) {
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $fields = "id,message,attachments";
        $post = $this->api->get('/' . $id .'?fields='.$fields, $access_token);
//        dd($post);
        $post = $post->getGraphNode()->asArray();
//        dd(empty($post['attachments']));
        $src_photos = [];
        if (!empty($post['attachments'][0]['subattachments'])) {
            foreach ($post['attachments'][0]['subattachments'] as $item) {
                $src_photos[] = $item['media']['image']['src'];
            }
        }
        $post['src_photos'] = $src_photos;
        return view('backend.PublishPage.update', ['post' => $post]);

    }


    public function publishPage(AdminRequestPublishPage $request) {


        $data = [];
        $data['message'] = $request->message;
//        $data['photos'] = $request->image_detail;
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $photos = [
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105555/phong-canh-3.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105809/phong-canh-4.jpg'
        ];
//        $photos = $request->image_detail;
        $fbMultipleImg = array();
//        dd($this->uploadPhoto($photos));
        foreach($this->uploadPhoto($photos) as $k => $multiPhotoId) {
            $fbMultipleImg["attached_media[$k]"] = '{"media_fbid":"' . $multiPhotoId . '"}';
        }
        $fbMultipleImg['message'] = $data['message'];
        try {
//            dd($fbMultipleImg);
            $page_id = '1943970019218960';
            $access_token = $this->getPageAccessToken();
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Thêm thành công'
            ]);
            $post = $this->api->post('/' . $page_id . '/feed', $fbMultipleImg, $access_token);
            return redirect()->route('admin.PublishPage.list');

        } catch (FacebookResponseException $e) {
            // showing error message
            print $e->getMessage();
            exit();
        } catch (FacebookSDKException $e) {
            print $e->getMessage();
            exit();
        }
    }

    function uploadPhoto($fbtargetPath)
    {
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $fbuploadMultiIdArr = array();
        foreach ($fbtargetPath as $key => $item) {
//            dd($this->api->fileToUpload('http://localhost'.$item));
//            $uploadImage[$key] = $this->api->post('/'.$page_id.'/photos', ['publish' => 'false', 'source' => $this->api->fileToUpload('http://localhost'.$item)], $access_token);
            try {
                $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload($item)], $access_token);
//                $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload("https://localhost".$item)], $access_token);
                $multiPhotoId = $results->getDecodedBody();
                if(!empty($multiPhotoId['id'])) {
                    $fbuploadMultiIdArr[] = $multiPhotoId['id'];
                }
            } catch (FacebookResponseException $e) {
                // showing error message
                //print $e->getMessage();
                exit();
            } catch (FacebookSDKException $e) {
                //print $e->getMessage();
                exit();
            }
        }
        return $fbuploadMultiIdArr;
    }

    public function updatePostPage(AdminRequestPublishPage $request, $id) {
        $data = [];
        $data['message'] = $request->message;
        $data['post_id'] = $id;

        $photos = [
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105809/phong-canh-4.jpg'
        ];
//        $photos = $request->image_detail;
        $fbMultipleImg = array();
//        dd($this->uploadPhoto($photos));
        foreach($this->uploadPhoto($photos) as $k => $multiPhotoId) {
            $fbMultipleImg["attached_media[$k]"] = '{"media_fbid":"' . $multiPhotoId . '"}';
        }
        $fbMultipleImg['message'] = $data['message'];
//        dd($fbMultipleImg);
        try {
//            dd($fbMultipleImg);
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Cập nhật thành công'
            ]);
            $access_token = $this->getPageAccessToken();
//            dd($this->api->post('/' . $data['post_id'], $fbMultipleImg, $access_token));
            $post = $this->api->post('/' . $data['post_id'], $fbMultipleImg, $access_token);
//        $post = $this->api->get('/' . $page_id . '/feed', $access_token);
//            $post = $post->getGraphNode()->asArray();

            return redirect()->route('admin.dasboard');

        } catch (FacebookResponseException $e) {
            // showing error message
            print $e->getMessage();
            exit();
        } catch (FacebookSDKException $e) {
            print $e->getMessage();
            exit();
        }
    }

    public function getDelete($id) {
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $post = $this->api->delete('/' . $id ,array('message' => 'dasdsa'), $access_token);
        $post = $post->getGraphNode();
        return redirect()->route('admin.PublishPage.list');
    }
}
