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
use App\Models\UserToken;
use App\Models\Provinces;
use App\Models\Regency;
use App\Models\District;
use Mail;
use App\Services\Whatsapp;

class AuthController extends Controller
{
    public function register(Request $request){
        $rules = [
            'email' => ['required'],
            'phone'=> ['required'],
            'name' => ['required'],
            'password' => ['required'],
            'otp'=>['required']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $user = User::where('email',$email)->where('phone',$phone)->first();
        if ($user != null) {
            return response()->json([
                'status' => 'error',
                'message' => 'email or phone allready exist'
            ], 404);
        }
        $password = $request->password;
        $role = RoleAccount::where('name_role',$request->role)->first();
        DB::beginTransaction();
        try {
            $account = new User;
            $account->name         = $name;
            $account->email        = $email;
            $account->phone        = $phone;
            $account->email_verified_at = Date::now();
            $account->password     = Hash::make($password);
            $account->role         = $role->id;
            $account->status       = 1;
            $account->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'internal_error'
            ], 500);
        }
        Otp::where('otp',$request->otp)->delete();
         return response()->json([
            'status' => 'success',
            'message' => 'Success'
        ], 200);
    }
    public function otp_send(Request $request){ 
        $rules = [
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
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

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }

        $username = $request->username;
        $password = $request->password;

        $usermail = User::where('email',$username)->first();
        $userphone = User::where('phone',$username)->first();
        if($usermail != null){
            $roleCheck = RoleAccount::where('id',$usermail->role)->first();
            if($roleCheck == null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'invalid_user'
                ], 404);
            }
            if(Auth::attempt(['email'=> $username, 'password' => $password])){
                $token = Str::random(40);
                $userAuth = Auth::user();

                $userToken = new UserToken();
                $userToken->user_id = $usermail->id;
                $userToken->token = $token;
                $userToken->save();

                $userAuth->token = $token;
                return response()->json([
                    'status' => 'success',
                    'data' =>  $userAuth
                ], 200);
            }
        }else
        if($userphone != null){
            $roleCheck = Role::where('name_role',$userphone->role)->first();
            if($roleCheck == null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'invalid_user'
                ], 404);
            }
            if(Auth::attemp(['phone'=> $username, 'password' => $password])){
                $token = Str::random(40);
                $userAuth = Auth::user();

                $userToken = new UserToken();
                $userToken->user_id = $userphone->id;
                $userToken->token = $token;
                $userToken->save();

                $userAuth->token = $token;
                return response()->json([
                    'status' => 'success',
                    'data' =>  $userAuth
                ], 200);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'invalid_username'
            ], 404);
        }

    }
    public function province(){
        $data = Provinces::get();
        return response()->json([
            'status'=>'success',
            'message'=>'success',
            'data'=>$data
        ]);
    }
    public function regency(Request $request){
        $data = Regency::where('province_code',$request->province_code)->get();
        return response()->json([
            'status'=>'success',
            'message'=>'success',
            'data'=>$data
        ]);
    }
    public function district(Request $request){
        $data = District::where('regency_code',$request->regency_code)->get();
        return response()->json([
            'status'=>'success',
            'message'=>'success',
            'data'=>$data
        ]);
    }
    public function token_validate(Request $request)
    {
        $token = $request->header('Token');
        if ($token == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'required_token'
            ], 404);
        }
        $userToken = UserToken::where('token', $token)->where('expired', '!=', 1)->first();
        if ($userToken == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'invalid_token'
            ], 404);
        }
        $expiredToken =  UserToken::where("user_id",  $userToken->user_id)
            ->update(["expired" => 1]);
        $token =  Str::random(40);
        $user = User::where('id',$userToken->user_id)->first();;

        $userToken = new UserToken();
        $userToken->user_id = $user->id;
        $userToken->token = $token;
        $userToken->save();

        $user->token = $token;

        return response()->json([
            'status' => 'success',
            'data' =>  $user
        ], 200);
    }
}
