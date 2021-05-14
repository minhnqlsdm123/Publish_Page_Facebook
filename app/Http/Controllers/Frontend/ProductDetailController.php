<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RattingProduct;
use App\MyService\ProcessViewService;
use Illuminate\Support\Facades\DB;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        $urlSegment2 = $request->segment(2);
        $uri = chop($urlSegment2, '.html');
        $arr = explode('-', $uri);
        $id = array_pop($arr);
        $product = Product::findOrFail($id);
        //Xử lí lượt view
        ProcessViewService::incrementViewProduct('products', 'pro_view', 'product', $id);
        //Thống kê ratting
        $rattingDashBoard = RattingProduct::where('r_product_id', $id)
            ->select(DB::raw('count(r_num_star) as count_num_star'), DB::raw('sum(r_num_star) as total_num_star'))
            ->groupBy('r_num_star')
            ->addSelect('r_num_star')
            ->get()
            ->toArray();
        $rattingDefault = $this->mapRattingDefault();
        foreach ($rattingDashBoard as $item) {
            $rattingDefault[$item['r_num_star']] = $item;
        }
        //Lấy ra các đánh giá của sản phẩm
        $rattings = RattingProduct::with('account:id,name')
            ->where('r_product_id', $id)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();

        $viewData = [
            'product' => $product,
            'rattings' => $rattings,
            'rattingDefault' => $rattingDefault
        ];
        return view('frontend.product.detail', $viewData);
    }

    private function mapRattingDefault()
    {
        $rattingDefault = [];
        for ($i = 1; $i <= 5; $i++) {
            $rattingDefault[$i] = [
                'r_num_star' => $i,
                'count_num_star' => 0,
                'total_num_star' => 0
            ];
        }
        return $rattingDefault;
    }

    public function getRattingAll(Request $request)
    {
        $urlSegment2 = $request->segment(2);
        $arr = explode('-', $urlSegment2);
        $id = array_pop($arr);
        $product = Product::findOrFail($id);
        //Thống kê ratting
        $rattingDashBoard = RattingProduct::where('r_product_id', $id)
            ->select(DB::raw('count(r_num_star) as count_num_star'), DB::raw('sum(r_num_star) as total_num_star'))
            ->groupBy('r_num_star')
            ->addSelect('r_num_star')
            ->get()
            ->toArray();
        $rattingDefault = $this->mapRattingDefault();
        foreach ($rattingDashBoard as $item) {
            $rattingDefault[$item['r_num_star']] = $item;
        }
        //Lấy ra các đánh giá của sản phẩm
        $rattings = RattingProduct::with('account:id,name')
            ->where('r_product_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(10);
        //Xử lí ajax phân trang ratting all
        if ($request->ajax()) {
            $query = $request->query();
            $html = view('frontend.product._include_ratting_list_item', compact('rattings', 'query'))->render();
            return response([
                'html' => $html
            ]);
        }

        $viewData = [
            'product' => $product,
            'rattingDefault' => $rattingDefault,
            'rattings' => $rattings,
            'query' => $request->query()
        ];
        return view('frontend.product.ratting_all', $viewData);
    }
}