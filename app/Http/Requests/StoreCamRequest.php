<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class StoreCamRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $rules = [
            'cEQP' => 'required|min:3|max:255|unique:cams',
            'tpAmb' => ['required', 'min:1', 'max:1'],
            'verAplic' => ['required', 'min:1', 'max:20'],
            'tpMan' => ['required', 'min:1', 'max:1'],
            'dhReg' => ['required', 'min:25', 'max:25'],
            'CNPJOper' => ['required', 'min:14', 'max:14'],
            'cEQP' => ['required', 'min:15', 'max:15'],
            'xEQP' => ['required', 'min:1', 'max:50'],
            'cUF' => ['required', 'min:2', 'max:2'],
            'tpSentido' => ['required', 'min:1', 'max:1'],
            'latitude' => ['required', 'min:1'], //float - criar validação
            'longitude' => ['required', 'min:1'], //float - criar validação
            'tpEQP' => ['required', 'min:1', 'max:1'],
            'xRefCompl' => ['required', 'min:2', 'max:200']
        ];

        if ($this->method() === 'PUT'  || $this->method() === 'PATCH') {
            $id = $this->support ?? $this->id;
            $rules['cEQP'] = [
                'required',
                'min:3',
                'max:255',
                ValidationRule::unique('cams')->ignore($id),
            ];
        }
        return $rules;
    }
}
