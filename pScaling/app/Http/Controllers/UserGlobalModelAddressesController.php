<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Address;

class UserGlobalModelAddressesController extends ResponseQueryController
{
    private function _select($id) {
        return User::whereIn('id', [$id])->first();
    }

    public function index($id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $collection = $user->userGlobalModel->addresses;
        return $this->responseCollection($collection);
    }

    public function store(Request $request, $id) {
        $this->validate($request, [
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|min:4|max:255',
            'first_name' => 'required|min:4|max:255',
            'last_name' => 'required|min:4|max:255',
            'address' => 'required|min:4|max:255',
            'floor' => 'required',
            'city' => 'required|min:4|max:255',
            'phone' => 'required|min:10|max:13'
        ]);

        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }

        $globalModel = $user->userGlobalModel;

        $addressAttrs = array(
            'user_global_model_id' => (int)$globalModel->id,
            'country_id' => (int)$request->country_id,
            'name' => trim($request->name),
            'first_name' => trim($request->first_name),
            'last_name' => trim($request->last_name),
            'address' => trim($request->address),
            'complement' => trim($request->complement),
            'floor' => (int)$request->floor,
            'elevator' => (int)$request->elevator,
            'city' => trim($request->city),
            'postcode' => trim($request->postcode),
            'phone' => trim($request->phone),
            'longitude' => (int)$request->longitude,
            'latitude' => (int)$request->latitude
        );

        if (! $address = Address::create($addressAttrs)) {
            return $this->responseItem(false);
        }

        if (!$globalModel->address) {
            $globalModel->address()->associate($address);
            $globalModel->save();
        }

        $item = $address;
        return $this->responseItem($item);
    }

    public function patch(Request $request, $id, $address_id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }

        $globalModel = $user->userGlobalModel;

        if (! $address = $user->userGlobalModel->address) {
            return $this->responseItem(false);
        }

        if (! $address = $user->userGlobalModel->addresses()->find($address_id)) {
            return $this->responseItem(false);
        }

        $attrs = $request->only(
            'country_id',
            'name',
            'last_name',
            'first_name',
            'phone',
            'address',
            'complement',
            'floor',
            'elevator',
            'city',
            'postcode',
            'longitude',
            'latitude'
        );


        if (isset($attrs['country_id'])) {
            $this->validate($request, [
                'country_id' => 'exists:countries,id'
            ]);
            $attrs['country_id'] = (int)$request->country_id;
        } else { $attrs['country_id'] = $address->country_id; }


        if (isset($attrs['name'])) {
            $this->validate($request, [
                'name' => 'min:4|max:255'
            ]);
            $attrs['name'] = trim($request->name);
        } else { $attrs['name'] = $address->name; }


        if (isset($attrs['last_name'])) {
            $this->validate($request, [
                'last_name' => 'min:4|max:255'
            ]);
            $attrs['last_name'] = trim($request->last_name);
        } else { $attrs['last_name'] = $address->last_name; }


        if (isset($attrs['first_name'])) {
            $this->validate($request, [
                'first_name' => 'min:4|max:255'
            ]);
            $attrs['first_name'] = trim($request->first_name);
        } else { $attrs['first_name'] = $address->first_name; }


        if (isset($attrs['phone'])) {
            $this->validate($request, [
                'phone' => 'min:10|max:13'
            ]);
            $attrs['phone'] = trim($request->phone);
        } else { $attrs['phone'] = $address->phone; }

        if (isset($attrs['address'])) {
            $this->validate($request, [
                'address' => 'min:4|max:255'
            ]);
            $attrs['address'] = trim($request->address);
        } else { $attrs['address'] = $address->address; }


        if (isset($attrs['complement'])) {
            $attrs['complement'] = trim($request->complement);
        } else { $attrs['complement'] = $address->complement; }

        if (isset($attrs['floor'])) {
            $attrs['floor'] = $request->floor;
        } else { $attrs['floor'] = $address->floor; }

        if (isset($attrs['elevator'])) {
            $attrs['elevator'] = $request->elevator;
        } else { $attrs['elevator'] = $address->elevator; }

        if (isset($attrs['city'])) {
            $this->validate($request, [
                'city' => 'min:4|max:255'
            ]);
            $attrs['city'] = trim($request->city);
        } else { $attrs['city'] = $address->city; }

        if (isset($attrs['postcode'])) {
            $this->validate($request, [
                'postcode' => 'min:5|max:5'
            ]);
            $attrs['postcode'] = trim($request->postcode);
        } else { $attrs['postcode'] = $address->postcode; }


        if (isset($attrs['longitude'])) {
            $attrs['longitude'] = trim($request->longitude);
        } else { $attrs['longitude'] = $address->longitude; }


        if (isset($attrs['latitude'])) {
            $attrs['latitude'] = trim($request->latitude);
        } else { $attrs['latitude'] = $address->latitude; }


        $address->country_id = $attrs['country_id'];
        $address->name = $attrs['name'];
        $address->last_name = $attrs['last_name'];
        $address->first_name = $attrs['first_name'];
        $address->phone = $attrs['phone'];
        $address->address = $attrs['address'];
        $address->complement = $attrs['complement'];
        $address->floor = $attrs['floor'];
        $address->elevator = $attrs['elevator'];
        $address->city = $attrs['city'];
        $address->postcode = $attrs['postcode'];
        $address->longitude = $attrs['longitude'];
        $address->latitude = $attrs['latitude'];

        $address->save();
        $item = $address;
        return $this->responseItem($item);
    }

    public function delete(Request $request, $id, $address_id) {
        if (! $user = $this->_select($id)) {
            return $this->responseItem(false);
        }
        $globalModel = $user->userGlobalModel;
        if (!$address = $globalModel->addresses()->find($address_id)) {
            return $this->responseItem(false);
        }
        $address->delete($address_id);
        if ($address_id === $globalModel->address_id) {
            $globalModel->address_id = null;
        }
        $globalModel->save();
        return $this->responseItem($address);
    }
}
