<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait BackendTrait
{
    public function getAccessKeyFileManagerBackend()
    {
        $rfDecode = @base64_decode(substr($_COOKIE['RF'], 16));
        $access_key = sha1('private-plain-salt' . $rfDecode);

        return $access_key;
    }

    public function checkUploadDirFileManager()
    {
        //Kiem tra thu muc upload
        if (Auth::check()) {
            $dir = public_path('upload/users/'.Auth::id());
            if (!is_dir($dir)) {
                $oldmask = umask(0);
                @mkdir($dir, 0775, true);
                umask($oldmask);
            }
            $cookie_value = str_random(16) . base64_encode('users/'.Auth::id());
            setcookie('RF', $cookie_value, time() + (86400), "/"); // 86400 = 1 day
        }
    }

}