<?php
/**
 * Name: DelayedMessage.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-29
 * Last Modified: 2016-03-29
 */
namespace Rcs\Bot\Http\Composers\Demos;

use Illuminate\View\View;

/**
 * Class DelayedMessage
 *
 * @package Rcs\Bot\Http\Composers\Demos
 */
class DelayedMessage
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('formSetup', [
            'route' => 'demos.delayedMessage',
        ]);

        $view->with('delays', [
            10  => '10 seconds',
            30  => '30 seconds',
            60  => '1 minute',
            120 => '2 minutes',
            300 => '5 minutes',
        ]);
    }
}
