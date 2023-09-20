<?php

namespace App\Webhooks;

use App\Models\LotteryPlayer;
use App\Models\LotteryTicket;
use Dragan\DiscordWebhooks\Services\Embed;
use Illuminate\Support\Collection;

class LotteryTicketsAddedWebhook extends Webhook
{
    /**
     * @param LotteryPlayer $lotteryPlayer
     * @param Collection<LotteryTicket> $tickets
     * @param bool $isFirstTicket
     */
    public function __construct(LotteryPlayer $lotteryPlayer, Collection $tickets, bool $isFirstTicket = false)
    {
        $this->webhook = (new \Dragan\DiscordWebhooks\Services\Webhook());
        $this->webhook->channel('lottery_tickets');

        if ($isFirstTicket) {
            $lottery = $lotteryPlayer->lottery;
            $message = "### ========================================\n";
            $message .= "### " . $lottery->title . "\n";
            $message .= "### ========================================\n";

            $this->webhook->message($message);
        }

        $embed = new Embed();
        $embed->title('Hráč ' . $lotteryPlayer->name . ' si koupil ' . $tickets->count() . ' lístků');
        $description = "Celková výhra se zvýšila na **" . number_format($lotteryPlayer->lottery->current_price, 0, ',', ' ') . "** Goldů\n";
        $description .= "Jeho čisla jsou:\n";

        // create visual representation of the tickets as a table
        $table = [];
        $table[] = ['-----', '-----', '-----', '-----', '-----'];
        $row = [];
        foreach ($tickets as $ticket) {
            $row[] = $ticket->ticket_number;
            if (count($row) === 5) {
                $table[] = $row;
                $row = [];
            }
        }
        if (count($row) > 0) {
            $table[] = $row;
        }
        $table[] = ['-----', '-----', '-----', '-----', '-----'];
        $description .= '```' . $this->table($table) . '```';
        $embed->description($description);


        $this->webhook->addEmbed($embed);
        $this->webhook->username('Loterie');
    }

    /**
     * @param array<array<string>> $table
     */
    private function table(array $table): string
    {
        $maxColumnWidths = [];
        foreach ($table as $row) {
            foreach ($row as $columnIndex => $column) {
                $maxColumnWidths[$columnIndex] = max($maxColumnWidths[$columnIndex] ?? 0, strlen($column));
            }
        }

        $tableString = '';
        foreach ($table as $row) {
            foreach ($row as $columnIndex => $column) {
                $tableString .= str_pad($column, $maxColumnWidths[$columnIndex] + 1);
            }
            $tableString .= "\n";
        }

        return $tableString;
    }
}
