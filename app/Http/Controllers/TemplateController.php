<?php
/**
 * Name: TemplateController.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-31
 * Last Modified: 2016-03-31
 */
namespace Rcs\Bot\Http\Controllers;

/**
 * Class TemplateController
 *
 * @package Rcs\Bot\Http\Controllers
 */
class TemplateController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function commandListing(): \Illuminate\View\View
    {
        return view('partials.templates.commands.listing');
    }
}
