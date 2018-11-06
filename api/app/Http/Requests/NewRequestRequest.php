<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Class NewRequestRequest
 * @package App\Http\Requests
 * @property integer $service_id
 */
class NewRequestRequest extends FormRequest
{

    /**
     * @var Service
     */
    public $service;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function () {
            $this->service = Service::with('users')->find($this->service_id);
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_id' => 'required|exists:services,id'
        ];
    }
}
