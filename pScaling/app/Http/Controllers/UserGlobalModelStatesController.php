<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserGlobalModelState;

class UserGlobalModelStatesController extends ResponseQueryController
{
    public function index() {
        $collection = UserGlobalModelState::all();
        return $this->responseCollection($collection);
    }

    public function show($id) {
        $item = UserGlobalModelState::find($id);
        return $this->responseItem($item);
    }
}
