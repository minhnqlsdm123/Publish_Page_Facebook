<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $productsNew = Product::orderBy('id', 'desc')
            ->select('id', 'pro_name', 'pro_slug', 'pro_price', 'pro_sale', 'pro_avatar', 'pro_status', 'pro_pay')
            ->take(3)->get();
        $viewData = [
            'productsNew' => $productsNew
        ];
        return view('frontend.home.index', $viewData);
    }
}