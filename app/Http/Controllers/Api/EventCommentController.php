<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\EventCommentService;
use Illuminate\Support\Facades\Validator;

class EventCommentController extends Controller
{
     protected $eventCommentService;
    public function __construct(EventCommentService $eventCommentService){
        $this->$eventCommentService = $eventCommentService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id,$slug)
    {
        $event = Event::where('slug',$slug)->first();
        $user = User::where('id',$id)->first();
        $rules = [
            'comments'=>['required']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        try {
            $data = [
                'user_id'=>$user->id,
                'event_id'=>$event->id,
                'comments'=>$request->comments
            ];
            $comment =  $this->$eventCommentService->createEventComment($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Success',
                'data' => $comment
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventComment  $eventComment
     * @return \Illuminate\Http\Response
     */
    public function show(EventComment $eventComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventComment  $eventComment
     * @return \Illuminate\Http\Response
     */
    public function edit(EventComment $eventComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventComment  $eventComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventComment $eventComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventComment  $eventComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventComment $eventComment)
    {
        //
    }
}
