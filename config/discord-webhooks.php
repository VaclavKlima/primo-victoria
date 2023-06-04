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
        'lottery' =>'https://discord.com/api/webhooks/1114949973222641704/lyDQUg6-7TqJ76PA2bebl-8t_KYB4bhFsZmDc7L6VPftuyFeejoYwUS0m6kntCrzzn1c',
        'lottery_tickets' => 'https://discord.com/api/webhooks/1114949296014512178/oRxxZ30-zYOyW6kPFiW7Q5AhoJbLxHcg-DhMG4AeELid33fc5GED5wDw5X52VFBxM6f-',
        'second_example_channel' => '',
    ],

];
