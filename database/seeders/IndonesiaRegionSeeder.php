<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class IndonesiaRegionSeeder extends Seeder
{
    private $baseUrl = 'https://emsifa.github.io/api-wilayah-indonesia/api';
    
    public function run(): void
    {
        $this->command->info('Memulai seeding data wilayah Indonesia...');
        
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        District::truncate();
        City::truncate();
        Province::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Ambil data dari API
        $this->seedProvinces();
        
        $this->command->info('Data wilayah Indonesia berhasil di-seed!');
    }
    
    private function seedProvinces()
    {
        $this->command->info('Mengambil data provinsi...');
        
        try {
            $response = Http::timeout(60)->get($this->baseUrl . '/provinces.json');
            $provinces = $response->json();
            
            foreach ($provinces as $province) {
                $prov = Province::create([
                    'code' => $province['id'],
                    'name' => $province['name']
                ]);
                
                $this->command->info("Provinsi: {$prov->name} ditambahkan");
                $this->seedCities($prov->code);
            }
            
        } catch (\Exception $e) {
            $this->command->error('Gagal mengambil data provinsi: ' . $e->getMessage());
            $this->seedManualData();
        }
    }
    
    private function seedCities($provinceId)
    {
        try {
            $response = Http::timeout(60)->get($this->baseUrl . "/regencies/{$provinceId}.json");
            $cities = $response->json();
            
            foreach ($cities as $city) {
                $cityModel = City::create([
                    'code' => $city['id'],
                    'province_id' => Province::where('code', $provinceId)->first()->id,
                    'name' => $city['name']
                ]);
                
                $this->seedDistricts($city['id']);
            }
            
        } catch (\Exception $e) {
            $this->command->error("Gagal mengambil data kota untuk provinsi {$provinceId}: " . $e->getMessage());
        }
    }
    
    private function seedDistricts($cityId)
    {
        try {
            $response = Http::timeout(60)->get($this->baseUrl . "/districts/{$cityId}.json");
            $districts = $response->json();
            
            foreach ($districts as $district) {
                $city = City::where('code', $cityId)->first();
                if ($city) {
                    District::create([
                        'code' => $district['id'],
                        'city_id' => $city->id,
                        'name' => $district['name']
                    ]);
                }
            }
            
        } catch (\Exception $e) {
            $this->command->error("Gagal mengambil data kecamatan untuk kota {$cityId}: " . $e->getMessage());
        }
    }
    
    // Fallback jika API tidak bisa diakses
    private function seedManualData()
    {
        $this->command->info('Menggunakan data manual...');
        
        // Data provinsi utama
        $provinces = [
            ['code' => '11', 'name' => 'ACEH'],
            ['code' => '12', 'name' => 'SUMATERA UTARA'],
            ['code' => '13', 'name' => 'SUMATERA BARAT'],
            ['code' => '14', 'name' => 'RIAU'],
            ['code' => '15', 'name' => 'JAMBI'],
            ['code' => '16', 'name' => 'SUMATERA SELATAN'],
            ['code' => '17', 'name' => 'BENGKULU'],
            ['code' => '18', 'name' => 'LAMPUNG'],
            ['code' => '19', 'name' => 'KEPULAUAN BANGKA BELITUNG'],
            ['code' => '21', 'name' => 'KEPULAUAN RIAU'],
            ['code' => '31', 'name' => 'DKI JAKARTA'],
            ['code' => '32', 'name' => 'JAWA BARAT'],
            ['code' => '33', 'name' => 'JAWA TENGAH'],
            ['code' => '34', 'name' => 'DAERAH ISTIMEWA YOGYAKARTA'],
            ['code' => '35', 'name' => 'JAWA TIMUR'],
            ['code' => '36', 'name' => 'BANTEN'],
            ['code' => '51', 'name' => 'BALI'],
            ['code' => '52', 'name' => 'NUSA TENGGARA BARAT'],
            ['code' => '53', 'name' => 'NUSA TENGGARA TIMUR'],
            ['code' => '61', 'name' => 'KALIMANTAN BARAT'],
            ['code' => '62', 'name' => 'KALIMANTAN TENGAH'],
            ['code' => '63', 'name' => 'KALIMANTAN SELATAN'],
            ['code' => '64', 'name' => 'KALIMANTAN TIMUR'],
            ['code' => '65', 'name' => 'KALIMANTAN UTARA'],
            ['code' => '71', 'name' => 'SULAWESI UTARA'],
            ['code' => '72', 'name' => 'SULAWESI TENGAH'],
            ['code' => '73', 'name' => 'SULAWESI SELATAN'],
            ['code' => '74', 'name' => 'SULAWESI TENGGARA'],
            ['code' => '75', 'name' => 'GORONTALO'],
            ['code' => '76', 'name' => 'SULAWESI BARAT'],
            ['code' => '81', 'name' => 'MALUKU'],
            ['code' => '82', 'name' => 'MALUKU UTARA'],
            ['code' => '91', 'name' => 'PAPUA BARAT'],
            ['code' => '92', 'name' => 'PAPUA'],
        ];
        
        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
}