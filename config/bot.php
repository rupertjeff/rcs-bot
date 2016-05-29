<?php

return [

    'commands' => [
        '!commands' => \Rcs\Bot\Commands\ListAllCommand::class,
        '!cmd'      => \Rcs\Bot\Commands\ListAllCommand::class,
        '!add'      => \Rcs\Bot\Commands\ManageCommands::class . '@add',
        '!edit'     => \Rcs\Bot\Commands\ManageCommands::class . '@update',
        '!update'   => \Rcs\Bot\Commands\ManageCommands::class . '@update',
        '!remove'   => \Rcs\Bot\Commands\ManageCommands::class . '@remove',
    ],
    
    'guilds' => [
        'Vex',
    ],

    'admin' => [
        'admin',
    ],

];
