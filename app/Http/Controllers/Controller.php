<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    /**
     * Add "error" key to the error message
     * @param Validator $validator
     * @return Array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        $res["error"] = $validator->errors()->messages();
        return $res;
    }
}
