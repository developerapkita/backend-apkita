<?php 
    namespace App\Services;
    use App\Models\Event;

class EventService{
    public function createEvent(array $data){
        return Event::create($data);
    }
    public function getEventByUser(string $id){
        return Event::join('user_communities','user_communities.community_id','events.community_id')->where('user_communities.user_id', $id)->get();
    }
    public function getEventByGroup(string $group){
        return Event::join('user_communities','user_communities.community_id','events.community_id')->where('user_communities.community_id', $group)->get();
    }
    public function updateEvent(string $slug, array $data){
        return Event::where('slug',$slug)->update($data);
    }
    public function deleteEvent(string $slug){
        return Event::where("slug",$slug)->delete();
    }
}