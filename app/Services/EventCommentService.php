<?php 
    namespace App\Services;
    use App\Models\EventComment;

class EventCommentService{
    public function createEventComment(array $data){
        return EventComment::create($data);
    }
    public function getEventCommentBySlug(string $slug){
        return EventComment::where('slug', $slug)->first();
    }
}