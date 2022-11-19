<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    use ResponseTrait;

    public function suggetions(Request $request)
    {
        error_log(json_encode($request->all()));
        $data=[];
        if($request->has('search') && $request->filled('search')){
            error_log('test');
            $response=Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json?input='.$request->search .'&types=geocode&key=' . env('GOOGLE_MAPS_API_KEY'))->json();
            if(isset($response['predictions'])){
                foreach ($response['predictions'] as $key => $value) {
                    $data[]=$value['description'];
                }
            }
        }
        error_log(json_encode($data));
        return $this->successResponse(code: 200, data: $data);
    }
}
