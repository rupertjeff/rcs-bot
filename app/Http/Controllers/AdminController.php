<?php
/**
 * Name: AdminController.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Http\Controllers;

use Illuminate\View\View;

/**
 * Class AdminController
 *
 * @package Rcs\Bot\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('pages.index');
    }
}
