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

    'guilds'       => explode('|', env('DISCORD_GUILDS')),
    'defaultGuild' => env('DISCORD_GUILD_DEFAULT', array_first(explode('|', env('DISCORD_GUILDS')))),

    'channels'       => explode('|', env('DISCORD_CHANNELS')),
    'defaultChannel' => env('DISCORD_CHANNEL_DEFAULT', array_first(explode('|', env('DISCORD_CHANNELS')))),

    'adminRoles' => explode('|', env('DISCORD_ADMIN_ROLES')),

];
