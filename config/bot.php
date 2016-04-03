<?php

return [

    'commands' => [
        '!commands' => \Rcs\Bot\Commands\ListAllCommand::class,
        '!cmd'      => \Rcs\Bot\Commands\ListAllCommand::class,
        '!add'      => \Rcs\Bot\Commands\ManageCommands::class . '@add',
        '!remove'   => \Rcs\Bot\Commands\ManageCommands::class . '@remove',
    ],

    'admin' => [
        'admin',
    ],

];
