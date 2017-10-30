<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserGlobalModelState;

class UserGlobalModelController extends ResponseQueryController
{
    private function _select($id) {
        return User::whereIn('id', [$id])->first();
    }

    public function show($id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $item = $user->userGlobalModel;
        return $this->responseItem($item);
    }

    public function update(Request $request, $id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }

        $globalModel = $user->userGlobalModel;
        $attrs = $request->only(
            'email',
            'password',
            'username',
            'last_name',
            'first_name',
            'phone'
        );


        if (isset($attrs['email'])) {
            $attrs['email'] = trim($request->email);
            if ($globalModel->email !== $attrs['email']) {
                $this->validate($request, [
                    'email' => 'min:4|max:255|unique:user_global_models,email'
                ]);
            }
        } else { $attrs['email'] = $globalModel->email; }


        if (isset($attrs['password'])) {
            $this->validate($request, [
                'password' => 'min:8|max:255'
            ]);
            $attrs['password'] = bcrypt($request->password);
        } else { $attrs['password'] = $globalModel->password; }


        if (isset($attrs['username'])) {
            $this->validate($request, [
                'username' => 'min:4|max:255'
            ]);
            $attrs['username'] = trim($request->username);
        } else { $attrs['username'] = $globalModel->username; }


        if (isset($attrs['last_name'])) {
            $this->validate($request, [
                'last_name' => 'min:4|max:255'
            ]);
            $attrs['last_name'] = trim($request->last_name);
        } else { $attrs['last_name'] = $globalModel->last_name; }


        if (isset($attrs['first_name'])) {
            $this->validate($request, [
                'first_name' => 'min:4|max:255'
            ]);
            $attrs['first_name'] = trim($request->first_name);
        } else { $attrs['first_name'] = $globalModel->first_name; }


        if (isset($attrs['phone'])) {
            $this->validate($request, [
                'phone' => 'min:10|max:13'
            ]);
            $attrs['phone'] = trim($request->phone);
        } else { $attrs['phone'] = $globalModel->phone; } 


        $globalModel->email = $attrs['email'];
        $globalModel->password = $attrs['password'];
        $globalModel->username = $attrs['username'];
        $globalModel->last_name = $attrs['last_name'];
        $globalModel->first_name = $attrs['first_name'];
        $globalModel->phone = $attrs['phone'];


        if ($globalModel->submitable()) {
            $globalModel->state_id = UserGlobalModelState::$SUBMITED;
        } else {
            $globalModel->state_id = UserGlobalModelState::$CREATED;
        }


        $user->email = $globalModel->email;
        $user->password = $globalModel->password;
        $user->userGlobalModel()->save($globalModel);
        $user->save();

        $item = $globalModel;
        return $this->responseItem($item);
    }
}
