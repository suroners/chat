<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ChatRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'mimes:jpeg,png,jpg',
            'name' => 'required',
            'slug' => 'required|unique:chats,slug'
        ];
    }
}
