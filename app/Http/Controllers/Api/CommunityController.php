<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\UserCommunity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use App\Helper\Communities as HelperCommunity;
use App\Services\AuthService;
use App\Services\CommunityService;
use App\Services\UserCommunityService;
class CommunityController extends Controller
{
    protected $authService;
    protected $communityService;
    protected $usercomService;
    public function __construct(AuthService $authService, CommunityService $communityService, UserCommunityService $usercomService){
        $this->authService = $authService;
        $this->communityService = $communityService;
        $this->usercomService = $usercomService;
    }
    public function create_community(Request $request, $slug){
        
        $user = $this->authService->userBySlug($slug);
        $rules = [
            'name'=>['required'],
            'description'=>['required'],
            'address'=>['required'],
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        try {
            $invite_code = HelperCommunity::generateCode(8);
            $data = [
                "invitation_code" =>$invite_code,
                "name" => $request->name,
                "image" => "image.jpg",
                "description" => $request->description,
                "address" => $request->address,
                "balance" => 0
            ];
            $create_community = $this->communityService->createDataCommunity($data);
            $user_community = [
                "user_id" => $user->id,
                "inviter_id" => $user->id,
                "community_id" => $create_community->id,
                "role" => 'manager',
                "is_owner" => 1,
                "is_accept" => 1,
                "responded_at" => Date::now()
            ];
            $create_usercom = $this->usercomService->createUserCommunity($user_community);
            return response()->json([
                'status' => 'success',
                'message' => 'Success',
                'data' => $create_usercom
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }
    }
    public function check_community($id){
        $community = Community::where('invitation_code',$id)->first();
        if($community ==null){
             return response()->json([
                'status' => 'error',
                'message' => 'invalid_code'
            ], 404);
        }
         return response()->json([
                'status' => 'success',
                'message' => 'Success',
                'data' => $community
            ], 200);
    }
    public function join_community_qr($id,$inviter,$slug){
        $user = $this->authService->userBySlug($slug);
        $inviters = $this->authService->userBySlug($inviter);
        $community = Community::where('invitation_code',$id)->first();
        try {
            $data=[
                'inviter_id'=> $inviters->id,
                'user_id'=>$user->id,
                'community_id'=>$community->id,
                'role'=>'member'
            ];
            $create_usercom = $this->usercomService->createDataCommunity($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Success',
                'data' => $create_usercom
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }
    }
}
