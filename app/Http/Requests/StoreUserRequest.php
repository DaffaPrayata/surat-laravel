<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role == Role::ADMIN->value;
    }

    public function attributes(): array
    {
        return [
            'name' => __('model.user.name'),
            'username' => __('model.user.username'),
            'email' => __('model.user.email'),
            'phone' => __('model.user.phone'),
        ];
    }

    public function rules(): array
{
    return [
        'name' => ['required'],
        'username' => ['required', 'unique:users,username'],
        'email' => ['required', 'email', 'unique:users,email'],
        'phone' => ['nullable'],
    ];
}

}
