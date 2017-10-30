<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hero;

class HeroesController extends Controller
{
    public function index(Request $request) {
        if (isset($request->name)) {
            $heroes = Hero::where('name', 'like', trim($request->name).'%')->get();
        } else { $heroes = Hero::all(); }
        return response()->json($heroes, 200);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:heroes,name|max:250'
        ]);
        if (! $hero = Hero::create(array(
            'name' => trim($request->name)
        ))) {
            return response()->json(null, 404);
        }
        return response()->json($hero, 201);
    }

    public function show($id) {
        $hero = Hero::find($id);
        return response()->json($hero,  ($hero ? 200 : 404));
    }

    public function patch(Request $request, $id) {
        if (! $hero = Hero::find($id)) {
            return response()->json(null, 404);
        }
        if (isset($request->name) && $hero->name !== $request->name) {
            $this->validate($request, [
                'name' => 'unique:heroes,name|max:250'
            ]);
            $hero->name = trim($request->name);
        }
        $hero->save();
        return response()->json($hero, 200);
    }

    public function delete($id) {
        $hero = Hero::find($id);
        $hero->delete();
        return response()->json($hero, ($hero ? 200 : 404));
    }
}
