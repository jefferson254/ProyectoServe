<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfessionalExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employer' => ['employer'],
            'position' => ['position'],
            'job_description' => ['job_description'],
            'start_date' => ['required', 'date_format:d.m.Y' ],
            'finish_date' => ['required', 'date_format:d.m.Y' ],
            'reason_leave' => ['reason_leave'],
            'current_work' => ['current_work']
        ];
    }
}
