<?php

namespace App\Http\Requests;

class UserAddressRequest extends Request
{
    public function rules()
    {
        return [
            'province'      => 'required',
            'city'          => 'required',
            'address'       => 'required',
            'zip'           => 'required',
            'contact_name'  => 'required',
            'contact_phone' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'province'      => 'Страна',
            'city'          => 'Город',
            'address'       => 'Адрес',
            'zip'           => 'Почтовый индекс',
            'contact_name'  => 'ФИО',
            'contact_phone' => 'Телефон',
        ];
    }
}
