<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Community;
use Illuminate\Support\Facades\Auth;
class EventController extends Controller
{
    protected $eventService;
    public function __construct(EventService $eventService,){
        $this->eventService = $eventService;
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
    public function create(Request $request)
    {
        $rules =[
            'community_id'=>['required'],
            'name'=>['required'],
            'description'=>['required'],
            'start_date'=>['required'],
            'end_date'=>['required'],
            'rsvp'=>['required'],
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        $data = [
            'community_id'=>$request->community_id,
            'name'=>$request->name,
            'description'=>$request->description,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'rsvp'=>$request->rsvp,
        ];
        $createData = $this->eventService->createEvent($data);
        return response()->json(['status' => 'success', 'data' => $createData], 200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByUser($slug)
    {
        $user = User::where('slug',$slug)->first();
        $event = $this->eventService->getEventByUser($user->id);
        return response()->json(['status' => 'success', 'data' => $event], 200);
    }
    public function showByGroup($slug)
    {
        $community = Community::where('slug',$slug)->first();
        $event = $this->eventService->getEventByGroup($community->id);
        return response()->json(['status' => 'success', 'data' => $event], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $rules = [
            'name'=>['required'],
            'description'=>['required'],
            'start_date'=>['required'],
            'end_date'=>['required'],
            'rsvp'=>['required'],
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ], 404);
        }
        $data = [
            'name'=>$request->name,
            'description'=>$request->description,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'rsvp'=>$request->rsvp,
        ];
        $update = $this->eventService->updateEvent($slug,$data);
        return response()->json(['status' => 'success', 'message'=>"Data updated successfully."], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->eventService->deleteEvent($slug);
        return response()->json(['status' => 'success', 'message'=>"Data deleted successfully."], 200);
    }
}
