<?php

namespace App\Http\Requests;

use App\Models\ProductSku;

class AddCartRequest extends Request
{
  public function rules()
  {
    return [
      'sku_id' => [
        'required',
        function ($attribute, $value, $fail) {
          if (!$sku = ProductSku::find($value)) {
            return $fail('Этот продукт не существует');
          }
          if (isset($sku->product->deleted_at)) {
            return $fail('Этот продукт недоступен');
          }
          if ($sku->stock === 0) {
            return $fail('Этот продукт распродан');
          }
          if ($this->input('amount') > 0 && $sku->stock < $this->input('amount')) {
            return $fail('Товар отсутствует на складе');
          }
        },
      ],
      'amount' => ['required', 'integer', 'min:1'],
    ];
  }

    public function attributes()
    {
      return [
        'amount' => 'Количество товаров'
      ];
    }

    public function messages()
    {
      return [
        'sku_id.required' => 'Пожалуйста, выберите продукт'
      ];
    }
}
