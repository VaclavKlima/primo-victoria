<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default webhook color
    |--------------------------------------------------------------------------
    |
    | This options will be used as default color for the embeds.
    | Must be valid color code.
    |
    */
    'default_webhook_color' => 0x006eff,
    /*
    |--------------------------------------------------------------------------
    | Default webhook channel
    |--------------------------------------------------------------------------
    |
    | This options will be used when no other channel is specified.
    |
    */
    'default_channel' => env('DISCORD_DEFAULT_WEBHOOK', ''),


    /*
    |--------------------------------------------------------------------------
    | Other webhook channels
    |--------------------------------------------------------------------------
    |
    | Other Discord webhook channels.
    |
    */
    'channels' => [
        'lottery' => env('DISCORD_LOTTERY_WEBHOOK', ''),
        'lottery_tickets' => env('DISCORD_LOTTERY_TICKETS_WEBHOOK', ''),
        'second_example_channel' => '',
    ],

];
