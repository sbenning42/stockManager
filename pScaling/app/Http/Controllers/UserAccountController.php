<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserAccountController extends ResponseQueryController
{
    private function _select($id) {
        return User::whereIn('id', [$id])->first();
    }

    public function show($id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $item = $user->account;
        return $this->responseItem($item);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'account_id' => 'required|exists:accounts,id',
        ]);
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $user->account_id = $request->account_id;
        $user->save();
        $item = $user;
        return $this->responseItem($item);
    }
}
