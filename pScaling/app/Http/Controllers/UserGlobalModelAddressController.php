<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserGlobalModelState;

class UserGlobalModelAddressController extends ResponseQueryController
{
    private function _select($id) {
        return User::whereIn('id', [$id])->first();
    }

    public function show($id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $item = $user->userGlobalModel->address;
        return $this->responseItem($item);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'address_id' => 'required|exists:Addresses,id',
        ]);
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $globalModel = $user->userGlobalModel;
        if (! $address = $globalModel->addresses()->find($request->address_id)) {
            return $this->responseItem(false);
        }
        $globalModel->address()->associate($address);

        if ($globalModel->submitable()) {
            $globalModel->state_id = UserGlobalModelState::$SUBMITED;
        } else {
            $globalModel->state_id = UserGlobalModelState::$CREATED;
        }

        $user->userGlobalModel()->save($globalModel);
        $user->save();
        $item = $address;
        return $this->responseItem($item);
    }
}
