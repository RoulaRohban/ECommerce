<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index(){
        $user = Auth::user();
        $addresses = $user->addresses;
        return response()->json(['addresses' => $addresses ],200);
    }

    public function store(StoreAddressRequest $request){
        $user = Auth::user();
        $validated_data = $request->validated();
        $validated_data = array_merge($validated_data,['user_id' => $user->id]);
        Address::create($validated_data);
        return response()->json(['msg' => 'created Successfully' ],200);

    }
}
