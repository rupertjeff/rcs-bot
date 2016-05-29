<?php

namespace Rcs\Bot\Http\Requests\Command;

use Rcs\Bot\Http\Requests\Request;

/**
 * Class Update
 *
 * @package Rcs\Bot\Http\Requests\Command
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
            'command' => 'required',
            'action' => 'required',
        ];
    }
}
