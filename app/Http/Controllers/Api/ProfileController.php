<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use App\Models\Profile;


class ProfileController extends Controller
{
    protected $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    public function show($slug){
        try {
            $user = $this->profileService->getBySlug($slug);
            return response()->json(["message"=>"success","data"=>$user],200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update($slug){
        try {
            $validate = request()->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'province' => 'required',
                'regencies' => 'required',
                'districts' => 'required',
                'address' => 'required',
            ]);
            
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
