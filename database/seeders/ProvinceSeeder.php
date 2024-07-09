<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert([  'province_code'=>11,'province_name'=>'ACEH']);
        DB::table('provinces')->insert([  'province_code'=>12,'province_name'=>'SUMATERA UTARA']);
        DB::table('provinces')->insert([  'province_code'=>13,'province_name'=>'SUMATERA BARAT']);
        DB::table('provinces')->insert([  'province_code'=>14,'province_name'=>'RIAU']);
        DB::table('provinces')->insert([  'province_code'=>15,'province_name'=>'JAMBI']);
        DB::table('provinces')->insert([  'province_code'=>16,'province_name'=>'SUMATERA SELATAN']);
        DB::table('provinces')->insert([  'province_code'=>17,'province_name'=>'BENGKULU']);
        DB::table('provinces')->insert([  'province_code'=>18,'province_name'=>'LAMPUNG']);
        DB::table('provinces')->insert([  'province_code'=>19,'province_name'=>'KEPULAUAN BANGKA BELITUNG']);
        DB::table('provinces')->insert([  'province_code'=>21,'province_name'=>'KEPULAUAN RIAU']);
        DB::table('provinces')->insert([  'province_code'=>31,'province_name'=>'DKI JAKARTA']);
        DB::table('provinces')->insert([  'province_code'=>32,'province_name'=>'JAWA BARAT']);
        DB::table('provinces')->insert([  'province_code'=>33,'province_name'=>'JAWA TENGAH']);
        DB::table('provinces')->insert([  'province_code'=>34,'province_name'=>'DI YOGYAKARTA']);
        DB::table('provinces')->insert([  'province_code'=>35,'province_name'=>'JAWA TIMUR']);
        DB::table('provinces')->insert([  'province_code'=>36,'province_name'=>'BANTEN']);
        DB::table('provinces')->insert([  'province_code'=>51,'province_name'=>'BALI']);
        DB::table('provinces')->insert([  'province_code'=>52,'province_name'=>'NUSA TENGGARA BARAT']);
        DB::table('provinces')->insert([  'province_code'=>53,'province_name'=>'NUSA TENGGARA TIMUR']);
        DB::table('provinces')->insert([  'province_code'=>61,'province_name'=>'KALIMANTAN BARAT']);
        DB::table('provinces')->insert([  'province_code'=>62,'province_name'=>'KALIMANTAN TENGAH']);
        DB::table('provinces')->insert([  'province_code'=>63,'province_name'=>'KALIMANTAN SELATAN']);
        DB::table('provinces')->insert([  'province_code'=>64,'province_name'=>'KALIMANTAN TIMUR']);
        DB::table('provinces')->insert([  'province_code'=>65,'province_name'=>'KALIMANTAN UTARA']);
        DB::table('provinces')->insert([  'province_code'=>71,'province_name'=>'SULAWESI UTARA']);
        DB::table('provinces')->insert([  'province_code'=>72,'province_name'=>'SULAWESI TENGAH']);
        DB::table('provinces')->insert([  'province_code'=>73,'province_name'=>'SULAWESI SELATAN']);
        DB::table('provinces')->insert([  'province_code'=>74,'province_name'=>'SULAWESI TENGGARA']);
        DB::table('provinces')->insert([  'province_code'=>75,'province_name'=>'GORONTALO']);
        DB::table('provinces')->insert([  'province_code'=>76,'province_name'=>'SULAWESI BARAT']);
        DB::table('provinces')->insert([  'province_code'=>81,'province_name'=>'MALUKU']);
        DB::table('provinces')->insert([  'province_code'=>82,'province_name'=>'MALUKU UTARA']);
        DB::table('provinces')->insert([  'province_code'=>91,'province_name'=>'PAPUA BARAT']);
        DB::table('provinces')->insert([  'province_code'=>94,'province_name'=>'PAPUA']);

    }
}
