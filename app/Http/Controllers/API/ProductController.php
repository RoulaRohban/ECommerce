<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getByCategory($category_id){
        $category = Category::findOrFail($category_id);
        $products = $category->products;
        return response()->json(['products' => $products ],200);
    }
    public function random(){
        $products=  Product::inRandomOrder()->limit(10)->get();
        return response()->json(['products' => $products ],200);
    }

    public function getByBarcode($barcode){
        $product=Product::where('barcode',$barcode)->first();
        return response()->json(['product' => $product],200);

    }
}
