<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PlaceService;

class PlaceController extends Controller
{
    protected $placeService;
    public function __construct(PlaceService $placeService){
        $this->placeService = $placeService;
    }
   public function getProvince(){
    $data = $this->placeService->retrieveProvinces();
    return response()->json([
        'status'=>'success',
        'message'=>'success',
        'data'=>$data
    ]);
   }

    public function getRegenciesByProvinceCode($provinceCode)
    {
        $regencies = $this->placeService->getRegencyByProvinceCode($provinceCode);
        return response()->json([
            'status' => 'success',
            'message' => 'success',
            'regencies' => $regencies
        ]);
    }

   public function getDistrictByRegencyCode($regencyCode)
   {
       $regencies = $this->placeService->getDistrictByRegencyCode($regencyCode);
       return response()->json([
           'status' => 'success',
           'message' => 'success',
           'data' => $regencies
       ]);
   }
   
}
