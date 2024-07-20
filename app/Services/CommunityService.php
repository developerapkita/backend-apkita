<?php 
    namespace App\Services;
    use App\Models\Community;
    use App\Models\UserCommunity;
class CommunityService
{
    public function createDataCommunity(array $data)
    {
        return Community::create($data);
    }
    public function createUserCommunity(array $data)
    {
        return $data;
    }
}