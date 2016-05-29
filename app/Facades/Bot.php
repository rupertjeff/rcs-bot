<?php
/**
 * Name: Bot.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Bot
 *
 * @package Rcs\Bot\Facades
 */
class Bot extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rcs.bot';
    }

}
