<?php 
    namespace App\Services;
    use App\Models\EventComment;

class EventCommentService{
    public function createEventComment(array $data){
        return EventComment::create($data);
    }
    public function getEventComment(string $slug){
        return EventComment::join('events','events.id','event_comments.event_id')->where('events.slug', $slug)->get();
    }
}