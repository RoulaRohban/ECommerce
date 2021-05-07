<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\StoreUserRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','isValidToken','verify','resend']]);
    }
    public  function  register(StoreUserRequest $request){
        $data=$request->validated();
        $data['password']=bcrypt($data['password']);
      $user =User::create($data);
      $user->verification_code=(string) rand(11111, 99999);
      $user->save();
       // Mail::to($data['email'])->send(new VerfyEmail($data['verification_code']));
        return response()->json(['msg'=>'register successfully'],200);
    }
    public function verify(Request $request){
        $email=$request->get('email');
        $verify_code=$request->get('code');

        $user=User::whereEmail($email)->first();
        if($user){
            if((string)$verify_code==(string)$user->verification_code){
                $user->email_verified_at=Carbon::now()->toDateTime();
                $user->save();
                return response()->json(['msg'=>'email verify successfully'],200);
            }
            else {
                return response()->json(['msg'=>'wrong code'],422);
            }

        }
        return  response()->json(['msg' => 'invalid email'], 421);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required','email','max:255'],
            'password' => ['required','string','min:8','max:255']
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => 'An error was occurred', 'errors' => $validator->errors()->all()], 422);
        }
        $token_validty = 24 * 30 * 60;
        auth('api')->setTTL($token_validty);
        if (!$token = auth('api')->attempt($validator->validated())) {
            return  response()->json(['msg' => 'An error was occurred', 'errors' => 'Wrong email or password'], 401);
        }
        $user=User::whereEmail($request->get('email'))->first();
            if ($user->email_verified_at==null){
                return response()->json(['msg'=>'An error was occurred','errors'=>'you need to verify your email first'],502);
            }
            return $this->respondWithToken($token, $user);

    }
    protected function respondWithToken($token,$user)
    {
        ;
        return response()->json(['msg' => 'Login Successfully', 'token' => $token,'name'=>$user->name], 200);
    }
    protected function guard()
    {
        return Auth::guard();
    }
    public function isValidToken(Request $request)
    {
        $mac=$request->get('mac_address');
        if(auth('api')->check()==true){
            $user = JWTAuth::parseToken()->authenticate();
                    return response()->json([ 'valid' => auth('api')->check(),'name'=>$user->name],200);
                }


        return response()->json([ 'valid' => 'false' ],401);
    }
    public function resend(Request $request){
        $email=$request->get('email');
        $user=User::whereEmail($email)->first();
        $user->verification_code=(string) rand(11111,99999);
        $user->save();
//        try{ Mail::to($user->email)->send(new VerfyEmail($user->verification_code));}
//        catch(\Exception $e ) {
//            return response()->json(['msg' => 'server error please try again'], 424);
//        }
        return response()->json(['verification code resent successfully']);

    }

}
