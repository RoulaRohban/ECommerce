<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getParents(){
        $categories = Category::whereNull('parent_id')->get(['id','name']);
        return response()->json(['parents' => $categories ],200);
    }
    public function getChild($parent_id){
        $child = Category::with('subCategories')->where('parent_id',$parent_id)->get();
        return response()->json(['child' => $child ],200);
    }
}
