<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;

class AccountsController extends ResponseQueryController
{
    public function index() {
        $collection = Account::all();
        return $this->responseCollection($collection);
    }

    public function show($id) {
        $item = Account::find($id);
        return $this->responseItem($item);
    }
}
