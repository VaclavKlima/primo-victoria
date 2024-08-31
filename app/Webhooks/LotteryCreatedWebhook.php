<?php

namespace App\Webhooks;

use App\Models\Lottery;


class LotteryCreatedWebhook extends Webhook
{
    public function __construct(Lottery $lottery)
    {
        $this->webhook = (new \Dragan\DiscordWebhooks\Services\Webhook());
        $this->webhook->channel('lottery');
        $this->webhook->message('Začala nová loterie!');

        $message = "# Začala nová loterie!\n";
        $message .= "## " . $lottery->name . "\n\n";
        $message .= "**Vlastník:** " . $lottery->owner_name . "\n";
        $message .= "**Počáteční cena:** " . number_format($lottery->starting_price, 0 , ',', ' ')  . " Goldů\n";
        // $message .= "**Šance na výhru:** " . $lottery->chance_to_win . "%\n";
        $message .= "**Maximální počet lístků na hráče:** " . $lottery->maximum_tickets_per_player . "\n";
        $message .= "**Cena lístku:** " . $lottery->ticket_price . "Goldů\n";
        $message .= "**Losování proběhne:** <t:" . $lottery->end_date->timestamp . ":R> (". $lottery->end_date->format('d.m.Y H:i') .")\n\n";
        $message .= "Pro zapojení do loterie pošlete ve hře goldy na účet **" . $lottery->owner_name . "** s názvem **Lotterie**\n\n";

        $this->webhook->message($message);


        $this->webhook->username('Loterie');
    }


}
