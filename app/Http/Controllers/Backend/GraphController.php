<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestPublishPage;
use App\Models\Files;
use App\Models\Post;
use Facebook\Facebook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function index(Request $request) {
        $search = $request->message;
        if($search != ""){
            $posts = Post::where(function ($query) use ($search){
                $query->where('message', 'like', '%'.$search.'%');
            })
                ->paginate(2);
            $posts->appends(['message' => $search]);
        }
        else{
            $posts = Post::paginate(2);
        }
        return view('backend.PublishPage.index', ['posts' => $posts]);
    }

    public function store(AdminRequestPublishPage $request) {
        $photos = [
//            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105555/phong-canh-3.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105809/phong-canh-4.jpg'
        ];
            if ($request->image_detail && $request->video) {
                \Session::flash('toastr', [
                    'type'    => 'error',
                    'message' => 'Chỉ có thể đăng ảnh hoặc video'
                ]);
                return redirect()->back()->withInput();
            }

            if ($request->datetime && $request->status) {
                \Session::flash('toastr', [
                    'type'    => 'error',
                    'message' => 'Nếu đã chọn Lập lịch thì không cần chọn trạng thái'
                ]);
                return redirect()->back()->withInput();
            }

        $request->image_detail = $photos;
        $post = new Post();
        $post_facebook = $this->publishPage($request);
        $post->message = $request->message;
        $post->post_id = $post_facebook['id'];
        if ($request->datetime) {
            $post->status = Post::STATUS_PUBLISH_SCHEDULED;
            $post->published = false;
        }
        if ($request->status) {
            $post->status = $request->status;
        }
        if ($post->save()) {
            $photos = $request->image_detail;
                if ($photos) {
                    foreach ($photos as $item) {
                        if ($item) {
                            $file = new Files();
                            $file->url = $item;
                            $file->type = 'IMG';
                            $file->post_id = $post->id;
                            if (!$file->save()) {
                                \Session::flash('toastr', [
                                    'type' => 'danger',
                                    'message' => 'Có lỗi khi thêm ảnh'
                                ]);
                            }
                        }
                    }
                }
           DB::commit();
           \Session::flash('toastr', [
                 'type'    => 'success',
                 'message' => 'Thêm thành công'
           ]);
           return redirect()->route('admin.PublishPage.list')->withInput();
        } else {
           \Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Xử lí thất bại'
             ]);
           return redirect()->back()->withInput();
        }
    }
    public function detail($id) {
        $post = Post::where('id', $id)->with('file')->first();
        $post->file_count = count($post->file);
        return view('backend.PublishPage.update', ['post' => $post]);
    }

    public function update(Request $request, $id) {
        $post = Post::where('id', $id)->first();
        if ($post) {
            $request->post_id = $post->post_id;
            $photos = [
                'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105555/phong-canh-3.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105809/phong-canh-4.jpg',
                'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
            ];
//            $photos = $request->image_detail;
            $this->publishPage($request);

            $post->message = $request->message;
            $post->save();
            if ($photos) {
                $files = Files::where('post_id', $post->id)->get();
                if ($files) {
                    foreach ($files as $file) {
                        if (!$file->delete()) {
                            \Session::flash('toastr', [
                                'type' => 'danger',
                                'message' => 'Có lỗi khi Cap nhat anh'
                            ]);
                        }
                    }
                }
                foreach ($photos as $item) {
                    if ($item) {
                        $file = new Files();
                        $file->url = $item;
                        $file->type = 'IMG';
                        $file->post_id = $post->id;
                        if (!$file->save()) {
                            \Session::flash('toastr', [
                                'type' => 'danger',
                                'message' => 'Có lỗi khi Cap nhat anh'
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function getPageId() {
        $test = $this->api->get('/'.Auth::user()->facebook_id.'/accounts', Auth::user()->access_token);
        $test = $test->getGraphEdge()->asArray();
        dd($test);
    }
    public function getPageAccessToken(){
        try {
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

    public function publishPage($request)
    {
        $data = [];
        $data['message'] = $request->message;
        if ($request->image_detail) {
            $files = $request->image_detail;
        }
        if ($request->video) {
            $files = $request->video;
        }
        $fbMultipleData = array();
        if ($files != null) {
            if (is_array($files)) {
                foreach($this->uploadPhoto($files) as $k => $multiPhotoId) {
                    $fbMultipleData["attached_media[$k]"] = '{"media_fbid":"' . $multiPhotoId . '"}';
                }
            } else {
                $fbMultipleData['attached_media'] = '{"media_fbid":"' . $this->uploadVideo($files) . '"}';
            }
        }
        $fbMultipleData['message'] = $data['message'];
        if ($request->datetime) {
            $fbMultipleData['scheduled_publish_time'] = strtotime($request->datetime);
            $fbMultipleData['published'] = false;
        }
        if ($request->status == Post::STATUS_UNPUBLISH) {
            $fbMultipleData['published'] = false;
        }
        try {
            $page_id = '1943970019218960';
            $access_token = $this->getPageAccessToken();
            if ($request->post_id) {
                $post = $this->api->post('/' . $request->post_id, $fbMultipleData, $access_token);
            } else {
                $post = $this->api->post('/' . $page_id . '/feed', $fbMultipleData, $access_token);
                $post = $post->getGraphNode()->asArray();
            }
            return $post;
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
            if ($item) {
                try {
                    $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload($item)], $access_token);
//                  $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload(env('DOMAIN_URL').'/public'.$item)], $access_token);
                    $multiPhotoId = $results->getDecodedBody();
                    if(!empty($multiPhotoId['id'])) {
                        $fbuploadMultiIdArr[] = $multiPhotoId['id'];
                    }
                } catch (FacebookResponseException $e) {
                    //print $e->getMessage();
                    exit();
                } catch (FacebookSDKException $e) {
                    //print $e->getMessage();
                    exit();
                }
            }
        }
        return $fbuploadMultiIdArr;
    }
    public function uploadVideo($fbtargetPath)
    {
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        try {
            $results = $this->api->post('/'.$page_id.'/videos', ['source' => $this->api->videoToUpload(env('DOMAIN_URL').'/public'.$fbtargetPath)], $access_token);
            $video = $results->getDecodedBody();
            $video_id = $video['id'];
        } catch (FacebookResponseException $e) {
            //print $e->getMessage();
            exit();
        } catch (FacebookSDKException $e) {
            //print $e->getMessage();
            exit();
        }

    }

    public function repost($id)
    {
        $post = Post::where('id', $id)->first();
        $this->repostFacebook($post->post_id);
        $post->published = true;
        $post->status = Post::STATUS_PUBLISH;
        if ($post->save()) {
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Xoá thành công'
            ]);
            return view('backend.PublishPage.index');
        }
    }

    public function delete($id)
    {
        $post = Post::where('id', $id)->first();
        $this->getDeletePostFacebook($post->post_id);
        if ($post) {
            if ($post->delete()) {
                $files = Files::where('post_id', $post->id)->get();
                if ($files) {
                    foreach ($files as $file) {
                        $file->delete();
                    }
                }
                \Session::flash('toastr', [
                    'type' => 'success',
                    'message' => 'Xoá thành công'
                ]);
                return view('backend.PublishPage.index');
            } else {
                \Session::flash('toastr', [
                    'type' => 'danger',
                    'message' => 'Xóa thất bại'
                ]);
            }
        }

    }
    public function getDeletePostFacebook($post_id)
    {

            $access_token = $this->getPageAccessToken();
            $post_facebook = $this->api->delete('/' . $post_id ,array('message' => 'dasdsa'), $access_token);
            $post_facebook = $post_facebook->getGraphNode();
            return $post_facebook;
    }

    public function repostFacebook($post_id) {
        $access_token = $this->getPageAccessToken();
        $repost_facebook = $this->api->post('/' . $post_id ,array('is_published' => 'true'), $access_token);
        $repost_facebook = $repost_facebook->getGraphNode();
        return $repost_facebook;
    }


//    public function retrieveUserProfile(){
//        try {
//
//            $params = "first_name,last_name,age_range,gender";
//
//            $user = $this->api->get('/me?fields='.$params)->getGraphUser();
//
//            dd($user);
//
//        } catch (FacebookSDKException $e) {
//
//        }
//
//    }
//
//    public function publishToProfile(Request $request){
//        try {
//            $response = $this->api->post('/me/feed', [
//                'message' => $request->message
//            ])->getGraphNode()->asArray();
//            if($response['id']){
//                // post created
//            }
//        } catch (FacebookSDKException $e) {
//            dd($e); // handle exception
//        }
//    }
}
