<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;

class RolesController extends ResponseQueryController
{
    public function index() {
        $collection = Role::all();
        return $this->responseCollection($collection);
    }

    public function show($id) {
        $item = Role::find($id);
        return $this->responseItem($item);
    }
}
