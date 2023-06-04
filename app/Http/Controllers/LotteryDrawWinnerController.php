<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Webhooks\LotteryDrawWebhook;
use App\Webhooks\LotteryTicketsAddedWebhook;
use Illuminate\Support\Facades\Session;

class LotteryDrawWinnerController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Lottery $lottery)
    {
        if ($lottery->tickets()->count() < 1) {
            return redirect()
                ->back()
                ->with('error', 'Lottery has no tickets.');
        }

        // get the minimum and maximum ticket number
        $minTicketNumber = $lottery->tickets()->min('ticket_number');
        $maxTicketNumber = $lottery->tickets()->max('ticket_number');

        // get a random number between the minimum and maximum ticket number
        $winnerNumber = random_int($minTicketNumber, $maxTicketNumber);

        // get the ticket with the winning number
        $winnerTicket = $lottery->tickets()->where('ticket_number', $winnerNumber)->first();

        if ($winnerTicket === null) {
            Session::flash('info', 'No winner found for this lottery. Ticket number: ' . $winnerNumber);
        } else {
            Session::flash('success', 'Winner found for this lottery. Ticket number: ' . $winnerNumber . ' - ' . $winnerTicket->player->name);
        }

        $lottery->drawn_at = now();
        $lottery->save();

        (new LotteryDrawWebhook($lottery, $winnerNumber,$winnerTicket))->send();

        return redirect()
            ->back();


    }
}
