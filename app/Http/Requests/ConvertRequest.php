<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        switch (request()->method()) {
            case "POST":
                return $this->createValidator();
            break;
            case "PATCH":
                return $this->updateValidator();
            break;
        }
    }

    private function createValidator()
    {
        return [
            'file' => 'required|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',

        ];
    }

    private function updateValidator()
    {
        return [

        ];
    }

    public function attributes()
    {
        return [
            'file'      => 'File',
        ];
    }
}
