<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "userId" => "required|integer",
            "street" => "required|string",
            "number" => "required|integer",
            "zip" => "required|string",
            "city" => "required|string",
            "state" => "required|string",
            "country" => "required|string"
        ];
    }
}
