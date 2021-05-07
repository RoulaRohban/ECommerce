<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favourite\StoreFavouriteRequest;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function index(){
        $user = Auth::user();
        $favourites = $user->favourites;
        return response()->json(['favourites' => $favourites ],200);
    }

    public function store(StoreFavouriteRequest $request){
        $user = Auth::user();
        $validated_data = $request->validated();
        $validated_data = array_merge($validated_data,['user_id' => $user->id]);
        Favourite::create($validated_data);
        return response()->json(['msg' => 'created Successfully' ],200);

    }
}
