<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use App\Models\District;

class RegionController extends Controller
{
    // Get all provinces
    public function getProvinces(Request $request)
    {
        $search = $request->input('search');
        
        $provinces = Province::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->orderBy('name')
        ->get(['id', 'code', 'name']);
        
        return response()->json([
            'success' => true,
            'data' => $provinces
        ]);
    }
    
    // Get cities by province
    public function getCities(Request $request, $provinceId = null)
    {
        $search = $request->input('search');
        
        $query = City::with('province')
            ->when($provinceId, function($query, $provinceId) {
                return $query->where('province_id', $provinceId);
            })
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            });
        
        $cities = $query->orderBy('name')
            ->get(['id', 'code', 'province_id', 'name', 'type']);
        
        // Format nama dengan type
        $cities = $cities->map(function($city) {
            return [
                'id' => $city->id,
                'code' => $city->code,
                'province_id' => $city->province_id,
                'name' => $city->name . ($city->type ? ' (' . $city->type . ')' : ''),
                'type' => $city->type
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $cities
        ]);
    }
    
    // Get districts by city
    public function getDistricts(Request $request, $cityId = null)
    {
        $search = $request->input('search');
        
        $districts = District::with('city')
            ->when($cityId, function($query, $cityId) {
                return $query->where('city_id', $cityId);
            })
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get(['id', 'code', 'city_id', 'name']);
        
        return response()->json([
            'success' => true,
            'data' => $districts
        ]);
    }
    
    // Search all regions
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        if (!$search || strlen($search) < 2) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
        
        $provinces = Province::where('name', 'like', "%{$search}%")
            ->limit(5)
            ->get(['id', 'name']);
        
        $cities = City::where('name', 'like', "%{$search}%")
            ->with('province')
            ->limit(10)
            ->get(['id', 'name', 'province_id']);
        
        $districts = District::where('name', 'like', "%{$search}%")
            ->with('city')
            ->limit(15)
            ->get(['id', 'name', 'city_id']);
        
        $results = [
            'provinces' => $provinces,
            'cities' => $cities->map(function($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name . ' - ' . $city->province->name
                ];
            }),
            'districts' => $districts->map(function($district) {
                return [
                    'id' => $district->id,
                    'name' => $district->name . ' - ' . $district->city->name
                ];
            })
        ];
        
        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
}