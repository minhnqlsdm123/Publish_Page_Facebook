<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\AdminRequestProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminProductController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->with('category:id,c_name')
            ->select('id', 'pro_name', 'pro_price', 'pro_sale', 'pro_avatar', 'pro_cat_id', 'pro_status', 'pro_hot', 'created_at')->get();
        // dd($products);
        $viewData = [
            'products'   => $products
        ];
        return view('backend.product.index', $viewData);
    }
    public function getAdd()
    {
        $categories = Category::select('id', 'c_name', 'c_parent_id')->get()->toArray();
        $viewData = [
            'categories' => $categories,
        ];
        return view('backend.product.add', $viewData);
    }
    public function postAdd(AdminRequestProduct $request)
    {
         dd($request->all());
        // die();
        $product = new Product();
        $product->pro_name = $request->name;
        $product->pro_slug = \Str::slug($request->name);
        $product->pro_cat_id = $request->cat_id;
        $product->pro_price = $request->price;
        $product->pro_sale = $request->sale ?? 0;
        $product->pro_status = $request->status ?? 0;
        $product->pro_hot = $request->hot ?? 0;
        $product->pro_description = $request->description;
//        $product->pro_content = $request->content;
        $product->created_at = Carbon::now();
        $product->pro_avatar = $request->avatar;
        $product->pro_image_detail = $request->image_detail;
//        dd($product);
        try {
            DB::beginTransaction();
            $product->save();
            $productId = $product->id;
            $categoryId = $request->cat_id;
            //----------------
//            $this->syncInsertOrUpdateCate($categoryId, $productId);
            DB::commit();
            \Session::flash('toastr', [
                'type'    => 'success',
                'message' => 'Thêm thành công'
            ]);
            return redirect()->route('admin.product.list')->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            \Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Xử lí thất bại'
            ]);
            return redirect()->back()->withInput();
        }
    }

    public function getUpdate($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select('id', 'c_name', 'c_parent_id')->get()->toArray();
        $viewData = [
            'categories' => $categories,
            'product'    => $product
        ];
        return view('backend.product.update', $viewData);
    }

    public function postUpdate(AdminRequestProduct $request, $id)
    {
        // dd($request->all());
        // die();
        $product = Product::findOrFail($id);
        $product->pro_name = $request->name;
        $product->pro_slug = \Str::slug($request->name);
//        $product->pro_cat_id = $request->cat_id;
        $product->pro_price = $request->price;
        $product->pro_sale = $request->sale ?? 0;
        $product->pro_status = $request->status ?? 0;
        $product->pro_hot = $request->hot ?? 0;
        $product->pro_description = $request->description;
//        $product->pro_content = $request->content;
        $product->pro_avatar = $request->avatar;
        $product->pro_image_detail = $request->image_detail;
        $product->created_at = Carbon::now();
        //save
        try {
            DB::beginTransaction();
            $product->save();
            $productId = $product->id;
//            $categoryId = $request->cat_id;
            //----------------
//            $this->syncInsertOrUpdateCate($categoryId, $productId);
            DB::commit();
            \Session::flash('toastr', [
                'type'    => 'success',
                'message' => 'Cập nhập thành công'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Session::flash('toastr', [
                'type'    => 'error',
                'message' => 'Xử lí thất bại'
            ]);
        }
        return redirect()->back()->withInput();
    }

    private function syncInsertOrUpdateCate($categoryId, $productId)
    {
        $category = Category::find($categoryId);
        $categoriesParent = $category->getAllParents();
        $dataCategories = [];
        $dataCategories[] = (int) $categoryId;
        foreach ($categoriesParent as $item) {
            $dataCategories[] = $item->id;
        }
        // dd($dataCategories);
        // die();
        DB::table('categories_products')->where('product_id', $productId)->delete();
        foreach ($dataCategories as $cat) {
            DB::table('categories_products')->insert([
                'product_id' => $productId,
                'category_id' => $cat
            ]);
        }
    }

    //ajax show model
    public function ajaxShowModal(Request $request)
    {
        $idProduct = $request->idProduct;
        $product = Product::findOrFail($idProduct);
        $categories = Category::select('id', 'c_name', 'c_parent_id')->get()->toArray();

        $viewData = [
            'categories' => $categories,
            'product'    => $product
        ];
        $html = view('backend.product.modal_view', $viewData)->render();
        return response([
            'html' => $html,
            'idProduct' => $idProduct
        ]);
    }

    //Xoa sp
    public function getDelete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        DB::table('categories_products')->where('product_id', $id)->delete();
        \Session::flash('toastr', [
            'type'    => 'success',
            'message' => 'Xóa thành công'
        ]);
        return redirect()->route('admin.product.list');
    }
}
