<?php

namespace App\Http\Requests\Task;

class UpdateTaskRequest extends TaskRequest
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
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'title' => 'string|max:255',
            'is_completed' => 'boolean',
        ]);
    }
}
