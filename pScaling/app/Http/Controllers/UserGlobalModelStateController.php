<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserGlobalModelStateController extends ResponseQueryController
{
    private function _select($id) {
        return User::whereIn('id', [$id])->first();
    }

    public function show($id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $item = $user->userGlobalModel->state;
        return $this->responseItem($item);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'state_id' => 'required|exists:user_global_model_states,id',
        ]);
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $globalModel = $user->userGlobalModel;
        $globalModel->state_id = $request->state_id;
        $globalModel->save();
        $item = $globalModel;
        return $this->responseItem($item);
    }
}
