<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyToJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isJobSeeker() === true;
    }

    public function rules(): array
    {
        return [
            'cover_letter' => ['nullable','string','max:5000'],
        ];
    }
}
