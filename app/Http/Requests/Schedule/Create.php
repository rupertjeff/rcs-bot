<?php

namespace Rcs\Bot\Http\Requests\Schedule;

use Rcs\Bot\Http\Requests\Request;

/**
 * Class Create
 *
 * @package Rcs\Bot\Http\Requests\Schedule
 */
class Create extends Request
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
            'name' => 'required',
            'repeat' => 'required|in:daily,weekly,monthly',
            'start_at' => 'required|date_format:U',
            'end_at' => 'required|date_format:U',
        ];
    }
}
