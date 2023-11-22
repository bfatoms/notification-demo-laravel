<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'exists:users,id',
            'message' => 'string',
            'status' => 'required|string'
        ];
    }
}
