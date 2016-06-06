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

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'commands'], function () {
        Route::get('/', ['uses' => 'CommandController@index', 'as' => 'commands.index']);
        Route::post('/', ['uses' => 'CommandController@store', 'as' => 'commands.store']);
        Route::put('{command}', ['uses' => 'CommandController@update', 'as' => 'commands.update']);
        Route::delete('{command}', ['uses' => 'CommandController@delete', 'as' => 'commands.delete']);
    });

    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', ['uses' => 'MessageController@index', 'as' => 'messages.index']);
        Route::post('/', ['uses' => 'MessageController@store', 'as' => 'messages.store']);
        Route::put('{message}', ['uses' => 'MessageController@update', 'as' => 'messages.update']);
        Route::delete('{message}', ['uses' => 'MessageController@destroy', 'as' => 'messages.destroy']);
    });

    Route::group(['prefix' => 'schedules'], function () {
        Route::get('/', ['uses' => 'ScheduleController@index', 'as' => 'schedules.index']);
        Route::post('/', ['uses' => 'ScheduleController@store', 'as' => 'schedules.store']);
        Route::get('{schedule}', ['uses' => 'ScheduleController@show', 'as' => 'schedules.show']);
        Route::put('{schedule}', ['uses' => 'ScheduleController@update', 'as' => 'schedules.update']);
        Route::delete('{schedule}', ['uses' => 'ScheduleController@destroy', 'as' => 'schedules.destroy']);
    });

//    Route::group(['prefix' => 'scripts'], function () {
//        Route::get('/', ['uses' => 'ScriptController@index', 'as' => 'scripts.index']);
//        Route::post('/', ['uses' => 'ScriptController@store', 'as' => 'scripts.store']);
//        Route::delete('{script}', ['uses' => 'ScriptController@destroy', 'as' => 'scripts.destroy']);
//    });
    
    Route::group(['prefix' => 'templates'], function () {
        Route::get('app/index', ['uses' => 'TemplateController@appIndex', 'as' => 'templates.app.index']);
        Route::get('commands/listing', ['uses' => 'TemplateController@commandListing', 'as' => 'templates.commands.listing']);
        Route::get('schedules/index', ['uses' => 'TemplateController@scheduleIndex', 'as' => 'templates.schedules.index']);
        Route::get('schedules/listing', ['uses' => 'TemplateController@scheduleListing', 'as' => 'templates.schedules.listing']);
        Route::get('schedules/create', ['uses' => 'TemplateController@scheduleCreate', 'as' => 'templates.schedules.create']);
//        Route::get('scripts/select', ['uses' => 'TemplateController@scriptSelect', 'as' => 'templates.scripts.select']);
    });
    
    Route::get('{any}', function () {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    })->where('any', '.*');
});

Route::get('{any}', ['uses' => 'AdminController@index', 'as' => 'admin.index'])->where('any', '.*');
