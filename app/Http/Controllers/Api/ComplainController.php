<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ComplainService;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    
    /**
     * Create a new ComplainController instance.
     *
     * @param  \App\Services\ComplainService  $complainService
     * @return void
     */
    public function __construct(ComplainService $complainService)
    {
        // Dependency injection of the ComplainService class to the controller
        $this->complainService = $complainService;
    }
    public function show($slug){
        try {
            $complain = $this->complainService->getDataBySlug($slug);
            return response()->json([
                'message' =>"Get data successfully",
                'status' => 'success',
                'data' => $complain,
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th
            ]);
        }

    }
   public function create(Request $request){
        try {
            $validate = $request->validate([
                'community_id' => 'required',
                'user_id'=> 'required',
                'detail'=> 'required',
            ]);
            $complain = $this->complainService->createData($validate);
            return response()->json([
                'status' => 'success',
                'data' => $validate
            ]);
        } catch (\Throwable $th) {
           return response()->json([
               'status' => 'error',
               'message' => $th
           ],500);
        }
   } 
   public function update(Request $request, $complainId)
   {
       $validatedData = $request->validate([
           'detail' => 'required',
       ]);

       $complain = $this->complainService->updateData($complainId, $validatedData);
        if(!$complain){
            return response()->json([
                'message'=>'Data not found',
                'status' => 'error'
            ],404);
        }
       return response()->json([
           'status' => 'success',
           'data' => $validatedData
       ]);
   }
   public function delete($id){
        try {
            
            $complain = $this->complainService->deleteData($id);
            if(!$complain){
                return response()->json([
                    'message'=>'Data not found',
                    'status' => 'error'
                ],404);
            }
            return response()->json([
                'message'=>'Delete data successfully',
                'status' => 'success'
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th
            ],500);
        }
   }

    
}
