<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $application = $this->route('application');
        return $this->user()?->isEmployer() === true
            && $application?->job?->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['viewed','shortlisted','rejected','hired'])],
        ];
    }
}
