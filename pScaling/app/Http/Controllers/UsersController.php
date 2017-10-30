<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Account;
use App\Address;

use App\UserGlobalModel;
use App\UserGlobalModelState;


class UsersController extends ResponseQueryController
{
    private function _select($id) {
        return User::whereIn('id', [$id])->first();
    }

    public function index() {
        $collection = User::all();
        return $this->responseCollection($collection);
    }
    public function show($id) {
        $item = User::find($id);
        return $this->responseItem($item);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'email' => 'required|min:4|max:255|unique:users,email',
            'password' => 'required|min:8|max:255',
        ]);
        $userAttrs = array(
            'role_id' => Role::$NONE,
            'account_id' => Account::$NONE,
            'email' => trim($request->email),
            'password' => bcrypt($request->password)
        );
        if (! $user = User::create($userAttrs)) {
            return $this->responseItem(false);
        }
        $userGlobalModelAttrs = array(
            'user_id' => $user->id,
            'state_id' => UserGlobalModelState::$CREATED,
            'email' => $user->email,
            'password' => $user->password,
        );
        if (! $userGlobalModel = UserGlobalModel::create($userGlobalModelAttrs)) {
            $user->forceDelete();
            return $this->responseItem(false);
        }
        $item = $user;
        return $this->responseItem($item);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'email' => 'required|min:4|max:255',
            'password' => 'min:8|max:255',
        ]);
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $userGlobalModel = $user->userGlobalModel;
        $attrs = $request->only('email', 'password');
        $attrs['email'] = trim($attrs['email']);
        if ($user->email !== $attrs['email']) {
            $this->validate($request, [
                'email' => 'unique:users,email'
            ]);  
        }
        if (isset($attrs['password'])) {
            $attrs['password'] = bcrypt($attrs['password']);
        } else {
            $attrs['password'] = $user->password;
        }
        $user->email = $attrs['email'];
        $user->password = $attrs['password'];
        $userGlobalModel->email = $user->email;
        $userGlobalModel->password = $user->password;
        $user->userGlobalModel()->save($userGlobalModel);
        $user->save();
        $item = $user;
        return $this->responseItem($item);
    }

    public function delete(Request $request, $id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        if ($user->userGlobalModel) {
            $user->userGlobalModel->delete();
        }
        $user->delete();
        $item = $user;
        return $this->responseItem($item);
    }
}
