<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPricingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ranges.*.from' => ['required', 'distinct'],
            'ranges.*.to' => ['required', 'distinct'],
            'ranges.*.price' => ['required', 'distinct'],
            'above_range_price' => ['required', 'distinct'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'ranges.*.from.required' => 'This field is required.',
            'ranges.*.to.required' => 'This field is required.',
            'ranges.*.price.required' => 'This field is required.',

            'ranges.*.from.distinct' => 'From field has a duplicate value.',
            'ranges.*.to.distinct' => 'To field has a duplicate value.',
            'ranges.*.price.distinct' => 'Price field has a duplicate value.',

        ];
    }
}
