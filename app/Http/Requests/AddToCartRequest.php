<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
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
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(fn ($query) => $query->where('status', 'active')->whereNull('deleted_at')),
            ],
            'product_variant_id' => ['nullable', 'string', 'max:120'],
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

            $productId = (int) $this->input('product_id');
            $variantId = $this->input('product_variant_id');
            $quantity = (int) $this->input('quantity');

            $product = Product::active()->find($productId);

            if (! $product) {
                $validator->errors()->add('product_id', 'Product is not available.');

                return;
            }

            if ((bool) $product->has_variants && blank($variantId)) {
                $validator->errors()->add('product_variant_id', 'Please select a product variant.');

                return;
            }

            if ($variantId !== null && $variantId !== '') {
                $variant = collect($product->variants ?? [])->first(
                    fn (mixed $row): bool => is_array($row) && (string) ($row['sku'] ?? '') === (string) $variantId,
                );

                if (! is_array($variant)) {
                    $validator->errors()->add('product_variant_id', 'Selected variant does not belong to the product.');

                    return;
                }

                if (($variant['status'] ?? 'active') !== 'active') {
                    $validator->errors()->add('product_variant_id', 'Selected variant is inactive.');

                    return;
                }

                if ($quantity > (int) ($variant['stock'] ?? 0)) {
                    $validator->errors()->add('quantity', 'Quantity cannot exceed available stock.');
                }

                return;
            }

            if ($quantity > (int) ($product->stock ?? 0)) {
                $validator->errors()->add('quantity', 'Quantity cannot exceed available stock.');
            }
        }];
    }
}
