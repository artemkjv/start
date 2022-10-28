<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\RelatedWithUser;
use App\Rules\UserNotExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $roles = User::ROLES;
        if(\request()->user()->role !== $roles['admin'] && \request()->user()->role !== $roles['superuser']) {
            unset($roles['admin']);
        }
        unset($roles['superuser']);
        return [
            'name' => 'required|string',
            'email' => ['required', 'email', new UserNotExists(\request()->route('id'))],
            'telegram' => 'string',
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in($roles)],
            'pages' => ['exclude_unless:role,' . $roles['pseudo_admin'], 'array', new RelatedWithUser('pages')],
            'users' => ['exclude_unless:role,' . $roles['pseudo_admin'], 'array', new RelatedWithUser('users')],
            'all_users' => 'nullable'
        ];
    }
}
