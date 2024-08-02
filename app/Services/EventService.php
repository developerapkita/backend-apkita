<?php 
    namespace App\Services;
    use App\Models\Event;

class EventService{
    public function createEvent(array $data){
        return Event::create($data);
    }
    public function getEventBySlug(string $slug){
        return Event::where('slug', $slug)->first();
    }
    public function updateEvent(string $slug, array $data){
        return Event::where('slug',$slug)->update($data);
    }
    public function deleteEvent(string $slug){
        return Event::where("slug",$slug)->delete();
    }
}