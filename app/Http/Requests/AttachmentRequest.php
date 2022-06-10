<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'alt'           => 'nullable|string',
            'description'   => 'nullable|string',
            'disk'          => 'string|required',
            'extension'     => 'string|required',
            'mime'          => 'string|required',
            'name'          => 'string|required',
            'original_name'  => 'string|required',
            'path'          => 'string|required',
            'size'          => 'required|integer',
            'user_id'       => 'required|exists:users,id',
        ];
    }
}
