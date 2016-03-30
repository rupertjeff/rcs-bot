<?php
/**
 * Name: ChannelMessage.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-29
 * Last Modified: 2016-03-29
 */
namespace Rcs\Bot\Http\Composers\Demos;

use Discord;
use Illuminate\View\View;

/**
 * Class ChannelMessage
 *
 * @package Rcs\Bot\Http\Composers\Demos
 */
class ChannelMessage
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('formSetup', [
            'route' => 'demos.channelMessage',
        ]);
        
        $view->with('channels', Discord::getChannels()->pluck('name', 'name'));
    }
}
