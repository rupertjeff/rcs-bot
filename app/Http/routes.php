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
        $channel  = Discord::getChannel('bot-testing');
        $dMessage = $channel->sendMessage($content);
        \Rcs\Bot\Database\Models\Message::create([
            'content' => $dMessage->content,
        ]);

        return redirect('/')
            ->with('status', 'Message Posted!');
    },
]);
