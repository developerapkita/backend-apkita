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

class CommunityController extends Controller
{
    public function create_community(Request $request){
        
        $user = User::with('profile')->where('slug',$request->id)->first();
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

        $invite_code = HelperCommunity::generateCode(8);
        DB::beginTransaction();
        try {
            $community = new Community;
            $community->invitation_code = $invite_code;
            $community->name = $request->name;
            $community->image = "image.jpg";
            $community->description = $request->description;
            $community->address = $request->address;
            $community->balance = 0;
            $community->save();

            $userCommunity = new UserCommunity;
            $userCommunity->user_id = $user->id;
            $userCommunity->inviter_id = $user->id;
            $userCommunity->community_id = $community->id;
            $userCommunity->role = 'manager';
            $userCommunity->is_owner = 1;
            $userCommunity->is_accept = 1;
            $userCommunity->responded_at = Date::now();
            $userCommunity->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'internal_error'
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Success'
        ], 200);
        
    }
}
