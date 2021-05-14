<?php

namespace App\Http\Controllers\Backend;

use App\Enums\FileKey;
use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function storeProductPhoto(Request $request)
    {
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            $dir = '/upload/files/product-photos/' . date('Y/m/d') . '/';

            $this->createPublicFolder($dir);

            $uuid = $this->uploadFile($photo, $dir, 'PRODUCT_PHOTO', Files::class);

            return response()->json([
                'message' => 'Image saved Successfully',
                'uuid' => 'jjj'
            ], 200);
        }
    }

    /**
     * Upload file, return uuid of file
     * @param  $file
     * @param string $uploadDir
     * @param string $modelKey
     * @param string $modelType
     * @param int $modelId
     * @return string
     */
    private function uploadFile($file, $uploadDir, $modelKey, $modelType = '', $modelId = 0)
    {
        $uuid = Str::uuid();
        $extension = $file->getClientOriginalExtension();
        $newFileName = $uuid . '.' . $extension;

        $fileModel = new Files();
        $fileModel->uuid = $uuid;
        $fileModel->key = $modelKey;
        if ($modelType) {
            $fileModel->model_type = $modelType;
        }
        if ($modelId) {
            $fileModel->model_id = $modelId;
        }
        $fileModel->original_filename = $file->getClientOriginalName();
        $fileModel->file_type = $file->getMimeType();
        $fileModel->extension = $extension;
        $fileModel->relative_path = $uploadDir . $newFileName;
        $fileModel->is_temp = true;
        $fileModel->save();

        $file->move(public_path($uploadDir), $newFileName);

        return $uuid;
    }

    public function delete(Request $request)
    {
        $uuid = $request->input('uuid');
        $model = Files::where('uuid', $uuid)->first();

        if ($model) {
            @File::delete(public_path($model->relative_path));
            $model->delete();

            return response()->json([
                'status' => 'success',
                'message' => trans('label.notification.delete_success'),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Image not found!',
        ]);
    }
    function createPublicFolder(string $path = '')
    {
        if (!empty($path)) {
            $dir = public_path($path);
            if (!is_dir($dir)) {
                $oldmask = umask(0);
                @mkdir($dir, 0775, true);
                umask($oldmask);
            }
        }
    }
}