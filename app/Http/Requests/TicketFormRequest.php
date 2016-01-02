<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class TicketFormRequest extends Request
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
     *
     * @return array
     */
    public function rules()
    {
        $a = 3;
        return [
        'title' => 'required|min:3',
        'content' => 'required|min:10'
        ];
    }

    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
    public function messages()
    {
        return [
        'title.required' => 'Hey man, the :attribute is required',
        'title.min' => 'Hey man ,the :attribute must be at least 3 characters',
        'content.required'  => 'Hey man, the :attribute is required',
        'content.min' => 'Hey man ,the :attribute must be at least 10 characters',
        ];
    }
}
