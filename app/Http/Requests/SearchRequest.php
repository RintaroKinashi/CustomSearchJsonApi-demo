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
            'query.required' => '検索したい文字列を入力してください',
        ];
    }

    /**
     * バリデーションの前に実行されるバリデーションルール
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (is_null(config('googleSearch.api_key'))) {
                $validator->errors()->add('apiKey', 'APIキーが設定されていないため、検索を行えません。開発者にお問い合わせください。');
            }

            if (is_null(config('googleSearch.engine_id'))) {
                $validator->errors()->add('searchEngineId', '検索エンジンIDが設定されていないため、検索を行えません。開発者にお問い合わせください。');
            }
        });
    }
}
