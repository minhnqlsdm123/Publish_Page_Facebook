<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\BackendTrait;
use App\Traits\BaseTrait;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    use BackendTrait;

    public $status;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //check upload dir
            $this->checkUploadDirFileManager();

            // Sharing data to all views
            View::share([
                'keyAccessFileManagerBackend' => $this->getAccessKeyFileManagerBackend()
            ]);

            return $next($request);
        });
    }
}