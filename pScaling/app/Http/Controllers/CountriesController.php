<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;

class CountriesController extends ResponseQueryController
{
    public function index() {
        $collection = Country::all();
        return $this->responseCollection($collection);
    }

    public function show($id) {
        $item = Country::find($id);
        return $this->responseItem($item);
    }
}
