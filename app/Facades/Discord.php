<?php
/**
 * Name: Discord.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-29
 * Last Modified: 2016-03-29
 */
namespace Rcs\Bot\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Discord
 *
 * @package Rcs\Bot\Facades
 */
class Discord extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rcs.discord';
    }

}
