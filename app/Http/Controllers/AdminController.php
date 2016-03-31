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

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }
}
