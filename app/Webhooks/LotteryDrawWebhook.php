<?php

namespace App\Webhooks;

use App\Models\Lottery;
use App\Models\LotteryTicket;

class LotteryDrawWebhook extends Webhook
{

    public function __construct(Lottery $lottery,int $winnerNumber, ?LotteryTicket $lotteryTicket = null)
    {
        $this->webhook = (new \Dragan\DiscordWebhooks\Services\Webhook());
        $this->webhook->channel('lottery');

        $message = "## Losování " . $lottery->title . "\n";
        $message .= "Celková výhra: **" . number_format($lottery->current_price, 0 , ',', ' ')  . " Goldů**\n";
        $message .= "Šance na výhru: **" . $lottery->chance_to_win . "%**\n";
        $message .= "Počet prodaných lístků: **" . $lottery->tickets()->count() . "**\n";
        $message .= "Počet hráčů: **" . $lottery->players()->count() . "**\n";

        if ($lotteryTicket) {
            $message .= "Výherce: **" . $lotteryTicket->player->name . "**\n";
            $message .= "Výherní číslo: **" . $lotteryTicket->ticket_number . "**\n";
            $message .= "Výhra bude automaticky poslána poštu hráči.\n";
        } else {
            $message .= 'Výherní číslo: **' . $winnerNumber . "**\n";
            $message .= "Bohužel nikdo nevyhrál. Celková výhra se přesune do další loterie.\n";
        }


        $this->webhook->message($message);
        $this->webhook->username('Loterie');
    }


}
