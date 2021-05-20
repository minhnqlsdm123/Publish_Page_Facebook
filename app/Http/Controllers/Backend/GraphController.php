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

    public function index() {
        $posts = Post::paginate(3);
//            dd($posts->all());
        return view('backend.PublishPage.index', ['posts' => $posts]);
    }

    public function store(AdminRequestPublishPage $request) {
//        dd($request->all());
        $photos = [
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
//            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105555/phong-canh-3.jpg',
//            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105809/phong-canh-4.jpg'
        ];
        $request->image_detail = $photos;
        $post = new Post();
        $post_facebook = $this->publishPage($request);
        $post->message = $request->message;
        $post->post_id = $post_facebook['id'];
        $post->status = $request->status;
        if ($request->datetime) {
            $post->status = Post::STATUS_PUBLISH_SCHEDULED;
            $post->published = false;
        } else {
              if ($request->status == Post::STATUS_PUBLISH) {
                  $post->published = true;
              } else if($request->status == Post::STATUS_UNPUBLISH) {
                  $post->published = false;
              }
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
        return view('backend.PublishPage.update', ['post' => $post]);
    }

    public function update(Request $request, $id) {
        $post = Post::where('id', $id)->first();
        if ($post) {
            $request->post_id = $post->post_id;
            $photos = [
                'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105555/phong-canh-3.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105809/phong-canh-4.jpg'
            ];
//            $photos = $request->image_detail;
//            $page_id = '1943970019218960';
            $access_token = $this->getPageAccessToken();
            $fbMultipleImg = array();
            if ($photos != null) {
                foreach($this->uploadPhoto($photos) as $k => $multiPhotoId) {
                    $fbMultipleImg["attached_media[$k]"] = '{"media_fbid":"' . $multiPhotoId . '"}';
                }
            }
            $fbMultipleImg['message'] = $request->message;
            if ($request->datetime) {
                $fbMultipleImg['scheduled_publish_time'] = strtotime($request->datetime);
                $fbMultipleImg['published'] = false;
            }
            if ($request->status == Post::STATUS_UNPUBLISH) {
                $fbMultipleImg['published'] = false;
            }
            $access_token = $this->getPageAccessToken();
            $post = $this->api->post('/' . $request->post_id, $fbMultipleImg, $access_token);
            $post->message = $request->message;
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



    public function publishPage( $request) {

//        dd($request->all());
        $data = [];

        $data['message'] = $request->message;

        $photos = $request->image_detail;
        $page_id = '1943970019218960';
        $access_token = $this->getPageAccessToken();
        $fbMultipleImg = array();
        if ($photos != null) {
            foreach($this->uploadPhoto($photos) as $k => $multiPhotoId) {
                $fbMultipleImg["attached_media[$k]"] = '{"media_fbid":"' . $multiPhotoId . '"}';
            }
        }
        $fbMultipleImg['message'] = $data['message'];
        if ($request->datetime) {
            $fbMultipleImg['scheduled_publish_time'] = strtotime($request->datetime);
            $fbMultipleImg['published'] = false;
        }
        if ($request->status == Post::STATUS_UNPUBLISH) {
            $fbMultipleImg['published'] = false;
        }
//        dd($fbMultipleImg);
        try {
//            dd($fbMultipleImg);
            $page_id = '1943970019218960';
            $access_token = $this->getPageAccessToken();

                $post = $this->api->post('/' . $page_id . '/feed', $fbMultipleImg, $access_token);
                $post = $post->getGraphNode()->asArray();

//            dd($post);
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
                $info_file = pathinfo($item);
                try {
                    if ($info_file['extension'] == 'jpg' || $info_file['extension'] == 'png' || $info_file['extension'] == 'pjpeg') {
                        $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload($item)], $access_token);
//                      $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload(env('DOMAIN_URL').'/public'.$item)], $access_token);
                    }
                    if ($info_file['extension'] == 'mp4') {
                        $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->videoToUpload(env('DOMAIN_URL').'/public'.$item)], $access_token);
                    }
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

    public function updatePostPage(AdminRequestPublishPage $request, $id) {
        $data = [];
        $data['message'] = $request->message;
        $post = Post::where('id', $id)->first();
        $data['post_id'] = $post->post_id;

        $photos = [
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105259/phong-canh.jpg',
            'https://data.webnhiepanh.com/wp-content/uploads/2020/11/21105809/phong-canh-4.jpg'
        ];
//        $photos = $request->image_detail;
        $fbMultipleImg = array();
//        dd($this->uploadPhoto($photos));
//        foreach($this->uploadPhoto($photos) as $k => $multiPhotoId) {
//            $fbMultipleImg["attached_media[$k]"] = '{"media_fbid":"' . $multiPhotoId . '"}';
//        }
        $fbMultipleImg['message'] = $data['message'];
        $fbMultipleImg['published'] = false;
        try {
//            dd($fbMultipleImg);
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Cập nhật thành công'
            ]);
            $access_token = $this->getPageAccessToken();
            dd($this->api->post('/' . $data['post_id'], $fbMultipleImg, $access_token));
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
    public function repost($id) {
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

    public function delete($id) {
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
    public function getDeletePostFacebook($post_id) {

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
