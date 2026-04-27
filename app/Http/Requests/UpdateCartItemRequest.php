<?php

namespace App\Http\Requests;

use App\Models\CartItem;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * @return array<int, \Closure>
     */
    public function after(): array
    {
        return [function ($validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $itemId = (int) $this->route('id');
            $quantity = (int) $this->input('quantity');

            $item = CartItem::with('product')->find($itemId);

            if (! $item || ! $item->product) {
                $validator->errors()->add('quantity', 'Cart item is not available.');

                return;
            }

            if (($item->product->status ?? null) !== 'active') {
                $validator->errors()->add('quantity', 'Product is no longer active.');

                return;
            }

            if ($item->product_variant_id) {
                $variant = collect($item->product->variants ?? [])->first(
                    fn (mixed $row): bool => is_array($row) && (string) ($row['sku'] ?? '') === (string) $item->product_variant_id,
                );

                if (! is_array($variant) || ($variant['status'] ?? 'active') !== 'active') {
                    $validator->errors()->add('quantity', 'Variant is no longer active.');

                    return;
                }

                if ($quantity > (int) ($variant['stock'] ?? 0)) {
                    $validator->errors()->add('quantity', 'Quantity cannot exceed available stock.');
                }

                return;
            }

            if ($quantity > (int) ($item->product->stock ?? 0)) {
                $validator->errors()->add('quantity', 'Quantity cannot exceed available stock.');
            }
        }];
    }
}
