<?php
/**
 * Name: ComposerServiceProvider.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-29
 * Last Modified: 2016-03-29
 */
namespace Rcs\Bot\Providers;

use Illuminate\Support\ServiceProvider;
use Rcs\Bot\Http\Composers\Demos\CustomMessage;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('partials.demos.customMessage', CustomMessage::class);
    }
}
