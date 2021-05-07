<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api', ['except' => []]);
    }
    public  function edit(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'phone' => 'required|min:10',
            'password' => 'required',
        ]);
        if ($validator->fails())
            return  response()->json(['msg' => 'confirmation failed', 'errors' => $validator->errors()->all()], 422);
        $user=Auth::user();
        if (!(Hash::check($request->get('password'),  $user->password))) {
            return response()->json(['msg' => 'wrong password'], 403);
        } else {
            $user->name=$request->get('name');
            $user->phone=$request->get('phone');
            $user->save();
            return response()->json('data updated successfully',200);
        }
    }
}
