<?php

namespace App\Webhooks;

use Dragan\DiscordWebhooks\Exceptions\DiscordWebhookResponseException;
use Dragan\DiscordWebhooks\Services\Webhook as DiscordWebhook;
use Illuminate\Http\Client\Response;

class Webhook
{
    public DiscordWebhook $webhook;

    /**
     * @throws DiscordWebhookResponseException
     */
    public function send(): Response
    {
       return $this->webhook->send();
    }
}
