<?php

namespace Rcs\Bot\Http\Requests\Message;

use Rcs\Bot\Http\Requests\Request;

/**
 * Class Update
 *
 * @package Rcs\Bot\Http\Requests\Message
 */
class Update extends Request
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
        return [
            'content' => 'required',
        ];
    }
}
