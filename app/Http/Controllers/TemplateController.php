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

use Illuminate\View\View;

/**
 * Class TemplateController
 *
 * @package Rcs\Bot\Http\Controllers
 */
class TemplateController extends Controller
{
    /**
     * @return View
     */
    public function appIndex(): View
    {
        return view('partials.templates.app.index');
    }
    
    /**
     * @return View
     */
    public function commandListing(): View
    {
        return view('partials.templates.commands.listing');
    }

    /**
     * @return View
     */
    public function scheduleIndex(): View
    {
        return view('partials.templates.schedules.index');
    }

    /**
     * @return View
     */
    public function scheduleListing(): View
    {
        return view('partials.templates.schedules.listing');
    }

    /**
     * @return View
     */
    public function scheduleCreate(): View
    {
        return view('partials.templates.schedules.create');
    }

    public function scriptSelect(): View
    {
        return view('partials.templates.scripts.select');
    }
}
