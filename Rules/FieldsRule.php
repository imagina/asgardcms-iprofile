<?php

namespace Modules\Iprofile\Rules;

use Illuminate\Contracts\Validation\Rule;

class FieldsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
      
      foreach ($value as $field){
        if($field["name"] == "confirmPolytics" && !$field["value"]){
          return false;
        }
        
    }
      return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Debe aceptar los términos y condiciones';
    }
}
