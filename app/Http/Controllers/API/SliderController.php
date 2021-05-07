<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => []]);
    }
    public function index(){
        $slider=Slider::all();
        return response()->json(['slider'=>$slider],200);
    }
}
