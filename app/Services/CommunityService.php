<?php 
    namespace App\Services;
    use App\Models\Community;
    use App\Models\User;
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
    public function showDataCommunity(string $slug_user)
    {
        $user = User::where('slug',$slug_user)->first();
        $community = Community::join('user_communities','user_communities.community_id','communities.id')
        ->where('user_communities.user_id',$user->id)->first();
        return $community;
    }
}