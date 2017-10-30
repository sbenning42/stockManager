<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseQueryController extends Controller
{
    public function responseQuery($query) {
        return response()->json([
            'count' => $query->count(),
            'collection' => $query->get(),
        ], 200);    
    }

    public function responseCollection($collection) {
        return response()->json([
            'count' => $collection->count(),
            'collection' => $collection,
        ], 200);    
    }

    public function responseItem($item) {
        $returnValue = (
            ($item !== null && $item !== false)
            ? 200
            : 404
        );
        return response()->json($item, $returnValue);
    }
}
