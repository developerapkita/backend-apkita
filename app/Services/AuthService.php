<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Date;
class AuthService
{
    public function register(array $user, int $roleId){
        $data = array_merge($user, ['email_verified_at' => Date::now(), 'password' => Hash::make($user['password']),'role'=>$roleId,'status'=>1 ]);
        return User::create($data);
    }
    public function userBySlug(string $slug){
        $data = User::with('profile')->where('slug',$slug)->first();
        return $data;
    }
   
}