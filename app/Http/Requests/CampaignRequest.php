<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'from' => 'required|date|after:now',
            'to' => 'required|date|after:from',
            'total' => 'required|numeric|min:.01',
            'total' => 'required|numeric|min:.01',
            'daily_budget' => 'required|numeric|min:.01',
            'images' => 'required|array',
            'images.*' => "mimes:jpeg,jpg,png,gif|max:10000"

        ];
    }
}
