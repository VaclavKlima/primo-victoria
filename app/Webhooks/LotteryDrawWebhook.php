<?php

namespace App\Webhooks;

use App\Models\Lottery;
use App\Models\LotteryTicket;
use Dragan\DiscordWebhooks\Exceptions\DiscordWebhookValidationException;
use Illuminate\Support\Collection;

class LotteryDrawWebhook extends Webhook
{

    /**
     * @param Lottery $lottery
     * @param Collection<int> $winnerNumber
     * @param Collection<LotteryTicket> $lotteryTickets
     * @param float $winnersPercentage
     *
     * @throws DiscordWebhookValidationException
     */
    public function __construct(
        Lottery $lottery,
        Collection $winnerNumber,
        Collection $lotteryTickets,
        float $winnersPercentage
    ){
        $this->webhook = (new \Dragan\DiscordWebhooks\Services\Webhook());
        $this->webhook->channel('lottery');

        $message = "## Losování " . $lottery->title . "\n";
        $message .= "Celková výhra: **" . number_format($lottery->current_price, 0 , ',', ' ')  . " Goldů**\n";
        $message .= "Počet prodaných lístků: **" . $lottery->tickets()->count() . "**\n";
        $message .= "Počet zapojených hráčů: **" . $lottery->players()->count() . "**\n";

        if ($lotteryTickets->isNotEmpty()) {
            foreach ($lotteryTickets as $lotteryTicket) {
                $message .= "## Výherce\n";
                $message .= 'Výherce: **' . $lotteryTicket->player->name . "**\n";
                $message .= 'Výherní číslo: **' . $lotteryTicket->ticket_number . "**\n";
                $message .= "Procentuální výhra: **" . $winnersPercentage * 100 . "%**\n";
                $message .= 'Výhra: **' . number_format($lottery->current_price * $winnersPercentage, 0 , ',', ' ') . " Goldů**\n";
                $message .= "Vylosovaná čísla: **" . $winnerNumber->implode(', ') . "**\n";
            }

        } else {
            $message .= "Bohužel nikdo nevyhrál. Celková výhra se přesune do další loterie.\n";
            $message .= "Vylosovaná čísla: **" . $winnerNumber->implode(', ') . "**\n";
        }

        $this->webhook->message($message);
        $this->webhook->username('Loterie');
    }


}
