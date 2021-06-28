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
        $pages = $this->getPageIds();
        $search = $request->message;
        $page_id = $request->page_id;
        if($search != ""){
            $posts = Post::where('facebook_page_id', $page_id)
                ->where(function ($query) use ($search){
                $query->where('content', 'like', '%'.$search.'%');
            })
                ->orderBy('id', 'desc')
                ->paginate(10);
            $posts->appends(['message' => $search]);
        }
        else{
            $posts = Post::where('facebook_page_id', $page_id)->orderBy('id', 'desc')
                ->paginate(10);
        }
        $length = count($posts);
        return view('backend.PublishPage.index', ['posts' => $posts, 'pages' => $pages, 'length' => $length]);
    }

    public function getAdd()
    {
        $pages = $this->getPageIds();
        return view('backend.PublishPage.add', ['pages' => $pages]);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'content' => 'required',
                'page_id' => 'required'
            ],
            [
                'content.required' => 'Nội dung bài viết không được trống',
                'page_id.required' => 'Trang để đăng bài viết không được trống',
            ]
        );
        if ($request->image_detail[0] && $request->video && $request->upload_video) {
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

        $post = new Post();
        $post_facebook = $this->publishPage($request);
        $post->content = $request->content;
        $post->post_id = $post_facebook['id'];
        $post->facebook_page_id = $request->page_id;
        if ($request->datetime) {
            $post->published_time = $request->datetime;
            $post->status = Post::STATUS_PUBLISH_SCHEDULED;
        } else {
            $this->validate(
                $request,
                [
                    'status' => 'required'
                ],
                [
                    'status.required' => 'Trạng thái đăng bài viết không được trống',

                ]
            );
            $post->status = $request->status;
        }
        if ($post->save()) {
            if($request->image_detail) {
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
            }
            if ($request->video){
                $video = $request->video;
                if($video) {
                    $file = new Files();
                    $file->url = $video;
                    $file->type = 'VIDEO';
                    $file->post_id = $post->id;
                    if (!$file->save()) {
                        \Session::flash('toastr', [
                            'type' => 'danger',
                            'message' => 'Có lỗi khi video'
                        ]);
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
    public function detail($id)
    {
        $post = Post::where('id', $id)->with('file')->first();
        $post->file_count = count($post->file);
        return view('backend.PublishPage.update', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'content' => 'required',
            ],
            [
                'content.required' => 'Nội dung bài viết không được trống',
            ]
        );
        $post = Post::where('id', $id)->first();
        if ($post) {
            $request->post_id = $post->post_id;
            $this->publishPage($request);

            $post->content = $request->message;
            $photos = $request->image_detail;
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
                DB::commit();
                \Session::flash('toastr', [
                    'type'    => 'success',
                    'message' => 'Cập nhật thành công'
                ]);
                return redirect()->route('admin.PublishPage.list')->withInput();
            }
        }
    }

    public function repost($id)
    {
        $post = Post::where('id', $id)->first();
        // dd($post);
        $this->repostFacebook($post->post_id, $post->facebook_page_id);
        $post->status = Post::STATUS_PUBLISH;
        if ($post->save()) {
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Đăng lại thành công'
            ]);
            return redirect()->route('admin.PublishPage.list')->withInput();
        }
    }

    public function delete($id)
    {
        $post = Post::where('id', $id)->first();
        $this->getDeletePostFacebook($post->post_id, $post->facebook_page_id);
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
                return redirect()->route('admin.PublishPage.list')->withInput();
            } else {
                \Session::flash('toastr', [
                    'type' => 'danger',
                    'message' => 'Xóa thất bại'
                ]);
            }
        }

    }

    public function getPageIds()
    {
        $fields = "id,cover,name,email,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified";
        $pages = $this->api->get('/'.Auth::user()->facebook_id.'/accounts?fields='.$fields, Auth::user()->access_token);
        $pages = $pages->getGraphEdge()->asArray();
        return $pages;
    }
    public function getPageAccessToken($page_id)
    {
        try {
            $response = $this->api->get('/me/accounts', Auth::user()->access_token);
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

    public function publishPage($request)
    {
        $page_id= $request->page_id;
        $data = [];
        $data['content'] = $request->content;
        if ($request->image_detail) {
            $files = $request->image_detail;
        }
        if ($request->video) {
            $files = $request->video;
        }

        $fbMultipleData = array();
        if (!empty($files)) {
            if (is_array($files)) {
                foreach($this->uploadPhoto($files, $page_id) as $k => $multiPhotoId) {
                    $fbMultipleData["attached_media[$k]"] = '{"media_fbid":"' . $multiPhotoId . '"}';
                }
                $fbMultipleData['message'] = $data['content'];
                if ($request->datetime) {
                    $fbMultipleData['scheduled_publish_time'] = strtotime($request->datetime);
                    $fbMultipleData['published'] = false;
                }
                $access_token = $this->getPageAccessToken($page_id);
                if ($request->status == Post::STATUS_UNPUBLISH) {
                    $fbMultipleData['published'] = false;
                }

                if ($request->post_id) {
                    $post = $this->api->post('/' . $request->post_id, $fbMultipleData, $access_token);
                } else {
                    // dd($fbMultipleData);
                    $post = $this->api->post('/' . $page_id . '/feed', $fbMultipleData, $access_token);
                    $post = $post->getGraphNode()->asArray();
                }

            } else {
                if ($request->datetime) {
                    $fbMultipleData['scheduled_publish_time'] = strtotime($request->datetime);
                    $fbMultipleData['published'] = false;
                }
                if ($request->status == Post::STATUS_UNPUBLISH) {
                    $fbMultipleData['published'] = false;
                }
                $fbMultipleData['message'] = $data['content'];

                $post = $this->uploadVideo($files, $fbMultipleData, $page_id);
            }
        } else {
            $fbMultipleData['message'] = $data['content'];
            if ($request->datetime) {
                $fbMultipleData['scheduled_publish_time'] = strtotime($request->datetime);
                $fbMultipleData['published'] = false;
            }
            $access_token = $this->getPageAccessToken($page_id);
            if ($request->status == Post::STATUS_UNPUBLISH) {
                $fbMultipleData['published'] = false;
            }

            if ($request->post_id) {
                $post = $this->api->post('/' . $request->post_id, $fbMultipleData, $access_token);
            }
        }
        return $post;
    }

    function uploadPhoto($fbtargetPath, $facebook_page_id)
    {
        $page_id = $facebook_page_id;
        $access_token = $this->getPageAccessToken($page_id);
        $fbuploadMultiIdArr = array();
        foreach ($fbtargetPath as $key => $item) {
            if ($item) {
                try {
                    // $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload($item)], $access_token);
                    $results = $this->api->post('/'.$page_id.'/photos', ['published' => 'false', 'source' => $this->api->fileToUpload(env('DOMAIN_URL').'/public'.$item)], $access_token);
                    $multiPhotoId = $results->getDecodedBody();
                    if(!empty($multiPhotoId['id'])) {
                        $fbuploadMultiIdArr[] = $multiPhotoId['id'];
                    }
                } catch (FacebookResponseException $e) {
                    print $e->getMessage();
//                    exit();
                } catch (FacebookSDKException $e) {
                    print $e->getMessage();
//                    exit();
                }
            }
        }
        return $fbuploadMultiIdArr;
    }
    public function uploadVideo($fbtargetPath, $fbMultipleData, $facebook_page_id)
    {
        $page_id = $facebook_page_id;
        $access_token = $this->getPageAccessToken($page_id);
        $fbMultipleData['source'] = $this->api->videoToUpload(env('DOMAIN_URL').'/public'.$fbtargetPath);
        $fbMultipleData['description'] = $fbMultipleData['message'];

        try {
            $results = $this->api->post('/'.$page_id.'/videos', $fbMultipleData, $access_token);
            $results = $results->getGraphNode()->asArray();
            // $results = $this->api->post('/'.$page_id.'/videos', ['source' => $this->api->videoToUpload($fbtargetPath)], $access_token);
            // $video = $results->getDecodedBody();
            // $video_id = $video['id'];
            return $results;
        } catch (FacebookResponseException $e) {
            //print $e->getMessage();
            exit();
        } catch (FacebookSDKException $e) {
            //print $e->getMessage();
            exit();
        }

    }

    public function getDeletePostFacebook($post_id, $facebook_page_id)
    {

        $access_token = $this->getPageAccessToken($facebook_page_id);
        $post_facebook = $this->api->delete('/' . $post_id ,array('message' => 'dasdsa'), $access_token);
        $post_facebook = $post_facebook->getGraphNode();
        return $post_facebook;
    }

    public function repostFacebook($post_id, $facebook_page_id) {
        $access_token = $this->getPageAccessToken($facebook_page_id);
        $repost_facebook = $this->api->post('/' . $post_id ,array('is_published' => 'true'), $access_token);
        $repost_facebook = $repost_facebook->getGraphNode();
        // dd($repost_facebook);
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
