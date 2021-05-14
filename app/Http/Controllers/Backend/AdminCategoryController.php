<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestCategory;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = new Category();
        if ($name = $request->name) $categories = $categories->where('c_name', 'like', '%' . $name . '%');

        $categories = $categories->orderBy('id', 'desc')->get();
        //dd($categories);
        //dd(multi_category($categories, 0));
        $viewData = [
            'categories' => $categories
        ];
        return view('backend.category.index', $viewData);
    }

    public function getAdd()
    {
        $categories = Category::select('id', 'c_name', 'c_parent_id')->get()->toArray();
        $viewData = [
            'categories' => $categories
        ];
        return view('backend.category.add', $viewData);
    }
    public function postAdd(AdminRequestCategory $request)
    {
        $category = new Category();
        $category->c_name = $request->name;
        $category->c_slug = Str::slug($request->name);
        $category->c_parent_id = $request->parent_id ?? 0;
        $category->c_status = $request->status ? 1 : 0;
        $category->c_keyword = $request->keyword;
        $category->c_description = $request->description;
        $category->created_at = Carbon::now();
        //dd($category);
        //save
        $category->save();
        \Session::flash('toastr', [
            'type' => 'success',
            'message' => 'Thêm thành công'
        ]);
        return redirect()->route('admin.category.list');
    }

    public function getUpdate($id)
    {
        $categories = Category::select('id', 'c_name', 'c_parent_id')->get()->toArray();
        $category = Category::find($id);

        // dd($category->getAllParents());
        // die();
        $viewData = [
            'categories' => $categories,
            'category' => $category
        ];
        return view('backend.category.update', $viewData);
    }

    public function postUpdate(AdminRequestCategory $request, $id)
    {
        $category = Category::find($id);
        $category->c_name = $request->name;
        $category->c_slug = Str::slug($request->name);
        $category->c_parent_id = $request->parent_id ? 1 : 0;
        $category->c_status = $request->status ? 1 : 0;
        $category->c_keyword = $request->keyword;
        $category->c_description = $request->description;
        $category->created_at = Carbon::now();
        //save
        $category->save();
        \Session::flash('toastr', [
            'type' => 'success',
            'message' => 'Cập nhập thành công'
        ]);
        return redirect()->back();
    }

    public function getAction($action, $id)
    {
        if ($action) {
            $category = Category::find($id);
            // dd($category);
            // die();
            switch ($action) {
                case 'delete':
                    $categories = DB::table('category')->get();
                    $this->deleteChild($categories, $id);
                    \Session::flash('toastr', [
                        'type' => 'success',
                        'message' => 'Xóa thành công'
                    ]);
                    break;
                case 'status':
                    $category->c_status = !$category->c_status;
                    $category->save();
                    \Session::flash('toastr', [
                        'type' => 'success',
                        'message' => 'Cập nhập thành công'
                    ]);
                    break;
            }
            return redirect()->back();
        }
    }

    public function syncGetChild($categorys, $id)
    {
        foreach ($categories as $item) {
            if ($item->c_parent_id == $id) {
                $child = Category::find($item->id)->delete();
            }
        }
    }
    public function deleteChild($categories = "", $id)
    {
        foreach ($categories as $item) {
            if ($item->c_parent_id == $id) {
                DB::table('category')->where('c_parent_id', $id)->delete();
                $this->deleteChild($categories, $item->id);
            }
        }
        DB::table('category')->where('id', $id)->delete();
    }
}
