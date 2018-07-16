<?php

namespace Modules\Iprofile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
//use App\Http\Requests\Request;

//class LoginRequestProfile extends \Modules\Bcrud\Http\Requests\CrudRequest
class LoginRequestProfile extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            //'email.required' => trans('iprofile::validation.email is required')
        ];
    }
}
