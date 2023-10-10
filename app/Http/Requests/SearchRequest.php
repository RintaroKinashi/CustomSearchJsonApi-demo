<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'query' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'query.required' => trans('Validation_error_msg.query_required'),
        ];
    }

    /**
     * バリデーションの前に実行されるバリデーションルール
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty(config('googleSearch.api_key'))) {
                $validator->errors()->add('apiKey', trans('Validation_error_msg.empty_api_key'));
            }

            if (empty(config('googleSearch.engine_id'))) {
                $validator->errors()->add('searchEngineId', trans('Validation_error_msg.empty_engine_id'));
            }
        });
    }
}
