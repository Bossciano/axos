<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isEmployer() === true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:150'],
            'category' => ['nullable','string','max:100'],
            'employment_type' => ['required', Rule::in(['full_time','part_time','contract','internship','temporary'])],
            'location' => ['nullable','string','max:150'],
            'remote' => ['nullable','boolean'],
            'salary_min' => ['nullable','numeric','min:0'],
            'salary_max' => ['nullable','numeric','gte:salary_min'],
            'currency' => ['nullable','string','max:10'],
            'description' => ['required','string','max:10000'],
            'requirements' => ['nullable','string','max:10000'],
            'responsibilities' => ['nullable','string','max:10000'],
            'benefits' => ['nullable','string','max:10000'],
            'expires_at' => ['nullable','date','after_or_equal:today'],
        ];
    }
}
