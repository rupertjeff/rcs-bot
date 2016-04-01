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

Route::group(['prefix' => 'demos', 'middleware' => 'verify'], function () {
    Route::post('sendCustomMessage', [
        'as' => 'demos.customMessage', function (\Illuminate\Http\Request $request) {
            $content = $request->get('message');

            $job = new \Rcs\Bot\Jobs\SendMessage($content);
            dispatch($job);

            return redirect()
                ->route('demos.index')
                ->with('status', 'Message Posted!');
        },
    ]);

    Route::post('sendDelayedMessage', [
        'as' => 'demos.delayedMessage', function (\Illuminate\Http\Request $request) {
            $content = $request->get('delayed-message');

            $job = (new \Rcs\Bot\Jobs\SendMessage($content))->delay((int)$request->get('delayed-delay'));
            dispatch($job);

            return redirect()
                ->route('demos.index')
                ->with('status', 'Message Posted!');
        },
    ]);

    Route::post('sendChannelMessage', [
        'as' => 'demos.channelMessage', function (\Illuminate\Http\Request $request) {
            $content = $request->get('channel-message');
            $channel = $request->get('channel-name');

            dispatch(new \Rcs\Bot\Jobs\SendMessage($content, $channel));

            return redirect()
                ->route('demos.index')
                ->with('status', 'Message Posted!');
        },
    ]);

    Route::get('/', [
        'as' => 'demos.index', function () {
            return view('pages.demos.index');
        }
    ]);
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'commands'], function () {
        Route::get('/', ['uses' => 'CommandController@index', 'as' => 'commands.index']);
        Route::post('/', ['uses' => 'CommandController@store', 'as' => 'commands.store']);
        Route::put('/{command}', ['uses' => 'CommandController@update', 'as' => 'commands.update']);
        Route::delete('/{command}', ['uses' => 'CommandController@delete', 'as' => 'commands.delete']);
    });
    
    Route::group(['prefix' => 'templates'], function () {
        Route::get('commands/listing', ['uses' => 'TemplateController@commandListing', 'as' => 'templates.commands.listing']);
    });
});

Route::get('/', ['uses' => 'AdminController@index', 'as' => 'admin.index']);
