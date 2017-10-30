<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FileType;

class FileTypesController extends ResponseQueryController
{
    public function index() {
        $collection = FileType::all();
        return $this->responseCollection($collection);
    }

    public function show($id) {
        $item = FileType::find($id);
        return $this->responseItem($item);
    }
}
