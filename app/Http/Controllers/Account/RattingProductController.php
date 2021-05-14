<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RattingProduct;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Product;

class RattingProductController extends Controller
{
    public function postAdd(Request $request, $id)
    {
        if ($request->ajax()) {
            if (!$request->content) return response(['error' => 'Bạn đã để trống nội dung đánh giá']);
            if (strlen($request->content) > 100 || strlen($request->content) < 6) return response(['error' => 'Nội dung đánh giá có độ dài từ 6 đến 100 kí tự']);
            $ratting = new RattingProduct();
            $ratting->r_account_id = Auth::guard('account')->id();
            $ratting->r_product_id = $id;
            $ratting->r_num_star = $request->star_ratting;
            $ratting->r_content = $request->content;
            $ratting->created_at = Carbon::now();
            $ratting->save();
            //xử lí cập nhập bảng products
            if ($ratting->id) {
                $this->updateProductTable($id, $request->star_ratting);
            }
            //prepend đánh giá mới
            $html = view('frontend.product._include_ratting_item', compact('ratting'))->render();
            return response([
                'message' => 'Đánh giá sản phẩm thành công',
                'html' => $html
            ]);
        }
    }
    public function updateProductTable($id, $numStar)
    {
        $product = Product::findOrFail($id);
        $product->pro_review_star += $numStar;
        $product->pro_review_total++;
        $product->save();
    }
}