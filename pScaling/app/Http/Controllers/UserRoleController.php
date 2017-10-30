<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserRoleController extends ResponseQueryController
{
    private function _select($id) {
        return User::whereIn('id', [$id])->first();
    }

    public function show($id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $item = $user->role;
        return $this->responseItem($item);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'role_id' => 'required|exists:roles,id',
        ]);
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $user->role_id = $request->role_id;
        $user->save();
        $item = $user;
        return $this->responseItem($item);
    }
}
