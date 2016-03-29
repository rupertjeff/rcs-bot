<?php
/**
 * Name: CustomMessage.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-29
 * Last Modified: 2016-03-29
 */
namespace Rcs\Bot\Http\Composers\Demos;

use Illuminate\View\View;

class CustomMessage
{
    public function compose(View $view)
    {
        $view->with('formSetup', [
            'route' => 'demos.customMessage',
            'method' => 'post',
        ]);
    }
}
