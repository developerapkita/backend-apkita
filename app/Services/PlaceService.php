<?php
namespace App\Services;
use App\Models\Profile;
use App\Models\Provinces;
use App\Models\Regency;
use App\Models\District;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class PlaceService{
    public function retrieveProvinces() : array
    {
        return Provinces::all()->toArray();
    }
    public function getRegencyByProvinceCode(int $provinceCode): array
    {
        return Regency::where('province_code', $provinceCode)->get()->toArray();
    }
    public function getDistrictByRegencyCode(int $regencyCode): array
    {
        return District::where('regency_code', $regencyCode)->get()->toArray();
    }
}