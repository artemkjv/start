<?php

namespace App\Http\Requests\Page;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $roles = [];
        if(in_array(\request()->user()->role, [
            User::ROLES['superuser'],
            User::ROLES['admin'],
            User::ROLES['pseudo_admin']
        ])) {
            $roles = User::ROLE_PAGE;
            if(\request()->user()->role === User::ROLES['pseudo_admin']) {
                unset($roles['pseudo_admin']);
            }
        }
        return [
            'name' => 'required|string',
            'route' => 'required|string',
            'icon' => 'nullable|string',
            'is_visible' => 'nullable',
            'roles' => ['nullable', 'array'],
            'roles.*' => ['nullable', Rule::in($roles)],
            'page_group_id' => 'nullable|int|exists:page_groups,id'
        ];
    }
}
