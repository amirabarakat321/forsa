<?php

namespace App\Http\Controllers\Api;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
    use ApiReturn;

    public function index()
    {
        $countries = Country::where(['status' => 1])->get();

        return $this->apiResponse($countries, '', 200);
    }
}
