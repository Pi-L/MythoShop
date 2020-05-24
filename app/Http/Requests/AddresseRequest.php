<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Validation\Rule;

class AddresseRequest extends FormRequest
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

    public function rules()
    {
        $rules = [
            'name' => "nullable|max:50|regex:/(^[À-úa-zA-Z -]+$)/",
            'number' => 'required|string|min:1|max:10',
            'street' => 'required|string|min:1|max:255',
            'postcode' => 'required|string|min:1|max:10',
            'town' => 'required|string|min:1|max:60',
        ];

        return $rules;
    }

    // https://laravel.com/docs/6.x/validation#customizing-the-error-messages
    public function messages()
    {
        return [
            'name.regex' => 'Seul les lettres de l\'alphabet (accentués ou non), le tiré et l\'apostrophe sont autorisés.',

        ];
    }

     /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'number' => 'trim|escape',
            'name' => 'trim|capitalize|escape',
            'street'  => 'trim|escape',
            'postcode' => 'trim|escape',
            'town' => 'trim|capitalize|escape',
        ];
    }
}
