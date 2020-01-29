<?php

namespace App\Http\Requests;

class UserAddressRequest extends Request
{
    public function rules()
    {
        return [
            'country'      => 'required',
            'city'          => 'required',
            'street'       => 'required',
            'contact_phone' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'country'      => 'Страна',
            'city'          => 'Город',
            'address'       => 'Адрес',
            'contact_phone' => 'Телефон',
        ];
    }
}
