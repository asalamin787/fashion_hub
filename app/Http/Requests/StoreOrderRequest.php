<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $shippingRequired = ! $this->boolean('shipping_same_as_billing');

        return [
            // Billing
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:191'],
            'phone' => ['required', 'string', 'max:30'],
            'company_name' => ['nullable', 'string', 'max:150'],
            'country' => ['required', 'string', 'size:2'],
            'street_address' => ['required', 'string', 'max:255'],
            'apartment' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'state' => ['required', 'string', 'max:120'],
            'zip_code' => ['required', 'string', 'max:20'],

            // Shipping toggle
            'shipping_same_as_billing' => ['nullable', 'boolean'],

            // Shipping address — required when shipping differs from billing
            'shipping_first_name' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'max:100'],
            'shipping_last_name' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'max:100'],
            'shipping_phone' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'max:30'],
            'shipping_country' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'size:2'],
            'shipping_street_address' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'max:255'],
            'shipping_apartment' => ['nullable', 'string', 'max:255'],
            'shipping_city' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'max:120'],
            'shipping_state' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'max:120'],
            'shipping_zip_code' => [Rule::requiredIf($shippingRequired), 'nullable', 'string', 'max:20'],

            // Order extras
            'order_notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'terms' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'terms.accepted' => 'You must agree to the terms and conditions.',
        ];
    }
}
