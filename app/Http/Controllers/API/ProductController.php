<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getByCategory($category_id){
        $category = Category::findOrFail($category_id);
        $products = $category->products;
        return response()->json(['products' => $products ],200);
    }
}
