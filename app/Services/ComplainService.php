<?php 
    namespace App\Services;
    use App\Models\Complain;
class ComplainService {
    public function getDataBySlug(string $slug)
    {
        return Complain::where('slug', $slug)->first();
    }
    public function createData(array $data){
        return Complain::create($data);
    }
    public function updateData(string $slug, array $data){
        return Complain::where('slug',$slug)->update($data);
    }
    public function deleteData(string $slug){
        return Complain::where('slug', $slug)->delete();
    }
}