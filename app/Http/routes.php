<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('pages.index');
});

Route::post('sendCustomMessage', [
    'as' => 'demos.customMessage', function (\Illuminate\Http\Request $request) {
        $content  = $request->get('message');
        
        $job = new \Rcs\Bot\Jobs\SendMessage($content);
        dispatch($job);

        return redirect('/')
            ->with('status', 'Message Posted!');
    },
]);

Route::post('sendDelayedMessage', [
    'as' => 'demos.delayedMessage', function (\Illuminate\Http\Request $request) {
        $content = $request->get('delayed-message');

        $job = (new \Rcs\Bot\Jobs\SendMessage($content))->delay((int)$request->get('delayed-delay'));
        dispatch($job);
        
        return redirect('/')
            ->with('status', 'Message Posted!');
    },
]);
