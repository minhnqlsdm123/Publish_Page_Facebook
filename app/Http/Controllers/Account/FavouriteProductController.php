<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FavouriteProductController extends Controller
{
    public function postAdd(Request $request, $id)
    {
        if ($request->ajax()) {
            $product = Product::find($id);
            if (!$product) return response(['message' => 'Sản phẩm không tồn tại']);
            $message = 'Yêu thích thành công!';
            $code = 1;
            try {
                DB::table('favourites_products')->insert([
                    'fp_user_id' => Auth::guard('account')->id(),
                    'fp_product_id' => $id
                ]);
            } catch (\Exception $e) {
                $message = 'Sản phẩm này đã được yêu thích';
                $code = 2;
            }
            return response()->json([
                'message' => $message,
                'code' => $code
            ]);
        }
    }
}