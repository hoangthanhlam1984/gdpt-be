<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var int|null $userId */
        $userId = $this->route('userId');

        return [
            'name'     => ['sometimes', 'string', 'max:255'],
            'email'    => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => ['sometimes', 'string', 'min:6'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Filter the data to update only provided fields.
     */
    public function validated($key = null, $default = null)
    {
        return collect(parent::validated())->filter(fn ($value) => !is_null($value))->all();
    }
}
