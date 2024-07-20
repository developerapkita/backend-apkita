<?php
    namespace App\Services;
    use App\Models\UserCommunity;

class UserCommunityService {
    public function createUserCommunity(array $data) {
        return UserCommunity::create($data);
    }
}
