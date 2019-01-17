<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Common
{
    public static function validateForm(Request $request)
    {
        $rules = [
            'logo'     => ['mimes:jpeg,jpg,gif,bmp,png', 'dimensions:min_width=100,min_height=100','max:1024'],
            'name'    => 'sometimes|required',
            'firstName'    => 'sometimes|required',
            'lastName'    => 'sometimes|required',
            'email'    => 'sometimes|nullable|email'
        ];

        $messages = [
            'logo.mimes' => 'This file format is not accepted',
            'logo.dimensions' => 'Please upload a file greater than 100x100 and below 10Mb',
            'logo.max' => 'Please upload a file smaller than 10MB',
            'name.required' => 'Please provide a name',
            'firstName.required' => 'Please provide a First Name',
            'lastName.required' => 'Please provide a Last Name',
            'email.required' => 'Please provide an email',
            'email.email' => 'Please provide a valid email',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return self::_validatorReturn($validator);
        }

        return true;
    }

    protected static function _validatorReturn($validator)
    {
        // get the error messages from the validator
        $messages = $validator->messages();
        $messages = json_decode($messages, true);

        $returnMessages = [];
        foreach ($messages as $id => $message) {
            if (is_array($message)) {
                $message = $message[0];
            }
            $returnMessages[] = ["id" => ucfirst($id), "message" => $message];
        }

        // redirect our user back to the form with the errors from the validator
        return response()->json(["error" => true, "message" => $returnMessages], 200);
    }
}
