<?php
/**
 * Name: Index.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Http\Composers;

use Illuminate\View\View;

class Index
{
    public function compose(View $view)
    {
        $view->with('pageTitle', 'RCS Bot Admin');
    }
}
