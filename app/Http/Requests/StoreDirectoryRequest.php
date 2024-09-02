<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class StoreDirectoryRequest extends FormRequest {
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
            'cameras_id' => 'required|min:1|max:255',
            'tipo_conexao_id' => ['required', 'min:1', 'max:10'],
            'diretorio' => ['required', 'min:1', 'max:255'],
            'host' => ['required', 'min:1', 'max:25'],
            'login' => ['required', 'min:1', 'max:255'],
            'password' => ['required', 'min:1', 'max:255'],
            'porta' => ['required', 'min:1', 'max:10']
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
