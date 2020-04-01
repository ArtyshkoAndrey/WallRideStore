<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\ProductSku;

class OrderRequest extends Request
{
    public function rules()
    {
        return [
            'address'     => [
                'required',
            ],
            'items'          => ['required', 'array'],
            'items.*.productSku.id' => [ // 检查 items 数组下每一个子数组的 sku_id 参数
                'required',
                function ($attribute, $value, $fail) {
                    if (!$sku = ProductSku::find($value)) {
                        return $fail('Этот продукт не существует');
                    }
                    if ($sku->product->deteled_at !== null) {
                        return $fail('Этот продукт недоступен');
                    }
                    if ($sku->stock === 0) {
                        return $fail('Этот продукт распродан');
                    }
                    // 获取当前索引
                    preg_match('/items\.(\d+)\.productSku.id/', $attribute, $m);
                    $index = $m[1];
                    // Найти количество покупок, представленных пользователем на основе индекса
                    $amount = $this->input('items')[$index]['amount'];
                    if ($amount > 0 && $amount > $sku->stock) {
                        return $fail('Товар отсутствует на складе');
                    }
                },
            ],
            'items.*.amount' => ['required', 'integer', 'min:1'],
        ];
    }
}
