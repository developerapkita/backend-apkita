<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Models\User;
use App\Models\RoleAccount;
use App\Models\Otp;
use Carbon\Carbon;
use App\Models\UserToken;
use App\Models\Profile;
use App\Services\TokenService;
use Mail;
use App\Services\Whatsapp;
use App\Services\ReferalService;
use App\Services\AuthService;
use App\Services\ProfileService;

class AuthController extends Controller
{       
    protected $generateService;
    protected $tokenService;
    protected $authService;
    protected $profileService;
    public function __construct(ReferalService $generateService,TokenService $tokenService, AuthService $authService, ProfileService $profileService) {
        $this->generateService = $generateService;
        $this->tokenService = $tokenService;
        $this->authService = $authService;
        $this-> profileService = $profileService;
    }
    public function register(Request $request){
        $rules = [
            'email' => ['required'],
            'phone'=> ['required'],
            'name' => ['required'],
            'password' => ['required'],
            'otp'=>['required'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        $user = User::where('email',$request->email)->where('phone',$request->phone)->first();
        if($user != null){ return response()->json(['status' => 'error', 'message' => 'email or phone already exist'], 404); }
        $role = RoleAccount::where('name_role',$request->role)->first();
        $referalCheck = Profile::where('referal_code',$request->referal_code)->first();
        try {
            $auth = $this->authService->register($request->all(), $role->id);
            $profileData = [
                'user_id' => $auth->id,
                'referal_code' => $this->generateService->generate(3,4),
                'referal_code_inviter' => $referalCheck == null ? null : $request->referal_code,
            ];
            $profile = $this->profileService->createData($profileData);

            return response()->json([
                'status' => 'success',
                'data' => $auth
            ], 200);

            Otp::where('otp',$request->otp)->delete();
            return response()->json([
               'status' => 'success',
               'message' => 'Success'
           ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'internal_error'
            ], 500);
        }
  
    }
    public function otp_send(Request $request){ 
        $rules = [
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        $checkCurrentOTP = Otp::where('email',$request->email)->first();
        if( $checkCurrentOTP !=null){
            if(Date::now()->toDateTimeString() < $checkCurrentOTP->expired_at){
                Otp::where('email',$request->email)->delete();
            }
        }           
        
        $otp = new Otp();
        $code_otp = rand(100000,999999);
        $otp->email = $request->email;
        $otp->phone = $request->phone;
        $otp->otp = $code_otp;
        $otp->expired_at = Date::now()->addMinutes(5);
        $otp->save();
        
        $details = [
            'name' => $request->name,
            'otp' => $code_otp,
        ];
        $template = "Hallo, ". $request->name.".\nBerikut adalah kode OTP untuk Verifikasi akun APKITA.\nKode OTP Anda *". $code_otp."*\n*Jangan diberitahukan kode otp tersebut ke orang lain.*";
        $sendMail = Mail::to($request->email)->send(new \App\Mail\VerificationMail($details));
        $sendWhatsapp = Whatsapp::send($request->phone, $template);
        if($sendMail && $sendWhatsapp){
            return response()->json([
            'status' => 'success',
            'message' => 'Success'
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Send_otp_failed'
            ],404);
        
    }
    public function otp_verification(Request $request){
        $rules = [
            'email' => ['required'],
            'phone' => ['required'],
            'otp'   => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
             return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }

        $user = Otp::orWhere('email',$request->email)->orWhere('phone',$request->phone)->first();
        if($user == null){
            return response()->json([
                'status' => 'error',
                'message' => 'invalid_user'
            ], 404);
        }else
        {
            $user = Otp::where('otp',$request->otp)->first();
            if(Date::now() <= $user->expired_at){
                return response()->json([
                    'status' => 'success',
                    'message' => 'otp_verified',
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'otp_expired'
                ], 404);
            }
        }
    }

    public function login(Request $request){
        $rules = [
            'username' => ['required'],
            'password' => ['required']
        ];
        try {
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->messages()->first()
                ], 404);
            }
            $user = User::where('email', $request->username)
            ->orWhere('phone', $request->username)
            ->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'invalid_user'
                ], 404);
            }
            if(Auth::attempt(['email'=> $request->username, 'password' => $request->password]) || Auth::attempt(['phone'=> $request->username, 'password' => $request->password])){
                $user_auth = Auth::user();
                $token = $user_auth->createToken('auth_token', ['*'], Carbon::now()->addMinutes(60));
                if($user_auth->pin_transaction == null){
                    return response()->json([
                        'status' => 'success',
                        'message'=> 'PIN_Not_Set',
                        'token' => $token->plainTextToken,
                        'type_token'=>"Bearer",
                        'expires_at'=>$token->accessToken->expires_at,
                        'slug'=> $user_auth->slug,
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 'success',
                        'message'=> 'PIN_ready',
                        'token' => $token->plainTextToken,
                        'type_token'=>"Bearer",
                        'expires_at'=>$token->accessToken->expires_at,
                        'slug'=> $user_auth->slug,
                    ], 200);
                }
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'your username and password is wrong'
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
       
    }
    public function profile_complete(Request $request, $slug){
        $rules = [
            'birth_date'=> ['required'],
            'gender'=> ['required'],
            'province'=> ['required'],
            'regencies'=> ['required'],
            'districts'=> ['required'],
            'address'=> ['required'],
        ];
        try {
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->messages()->first()
                ], 404);
            }
            $profile = $this->profileService->updateData($slug, $request->all());
            return response()->json([
                'status' => 'succcess',
                'message' => 'Success',
                'data' => $profile
            ], 404);
        } catch (\Throwable $th) {
            throw $th;
        }
      
    }
    public function set_pin(Request $request,$id){
        $rules = [
            'pin'=> ['required'],
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }

        $user = User::where('slug',$id)->first();
        $user->pin_transaction = Hash::make($request->pin);
        $user->save();
        return response()->json([
            'status' => 'succcess',
            'message' => 'Success',
            'data' => $user
        ], 200);
    }
    public function pin_validate(Request $request,$id){
        $rules = [
            'pin'=> ['required'],
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }

        $user = User::where('slug',$id)->first();
        if(Hash::check($request->pin,$user->pin_transaction)==false){
            return response()->json([
             'status' => 'error',
             'message' => 'pin_invalid',
        ], 404);
        }
        return response()->json([
             'status' => 'success',
             'message' => 'pin_valid',
             'data' => $user
        ], 404);
    }
    public function update_pin(Request $request,$slug){
        $rules = [
            'pin'=> ['required'],
            'old_pin'=> ['required']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        $user = User::where('slug',$slug)->first();
        if(Hash::check($request->old_pin,$user->pin_transaction)==false){
            return response()->json([
             'status' => 'error',
             'message' => 'old_pin_invalid',
        ], 404);
        }
        $user->pin_transaction = Hash::make($request->pin);
        $user->save();
        return response()->json([
            'status' => 'succcess',
            'message' => 'Success',
            'data' => $user
        ], 200);
    
    }
    public function update_password(Request $request,$slug){
        $rules = [
            'password'=> ['required'],
            'old_password'=> ['required']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        $user = User::where('slug',$slug)->first();
        if(Hash::check($request->old_password,$user->password)==false){
            return response()->json([
             'status' => 'error',
             'message' => 'old_password_invalid',
        ], 404);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status' => 'succcess',
            'message' => 'Success',
            'data' => $user
        ], 200);
    
    }
}
