<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Webhooks\LotteryDrawWebhook;
use Illuminate\Support\Facades\Session;

class LotteryDrawWinnerController extends Controller
{
    public const WINNER_POOL_PERCENTAGE = [
        1 => 1,
        2 => 0.75,
        3 => 0.5,
        4 => 0.25,
        5 => 0.15,
        6 => 0.1,
        7 => 0.05,
        8 => 0.01,
    ];
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
        $winnersPercentage = 0;
        $drawnNumbers = collect();
        $winnerTickets = collect();
        foreach (self::WINNER_POOL_PERCENTAGE as $winnerPool => $percentage) {
            $numberOfDraws = max(1, $winnerPool - 3);
            $winnerNumber = collect(range($minTicketNumber, $maxTicketNumber))->random($numberOfDraws);
            dump($winnerNumber);
            $drawnNumbers = $drawnNumbers->merge($winnerNumber);

            $winnerTickets = $lottery->tickets()->whereIn('ticket_number', $winnerNumber)->take($numberOfDraws)->get();
            if ($winnerTickets->isNotEmpty()) {
                $winnersPercentage = $percentage;
                break;
            }
        }

        if ($winnerTickets->isNotEmpty()) {
            Session::flash('info', 'No winner found for this lottery. Ticket numbers: ' . $drawnNumbers->implode(', '));
        } else {
            Session::flash('success', 'Winner found for this lottery. Tickets number: ' . $winnerTickets->pluck('ticket_number')->implode(', '));
        }

        $lottery->drawn_at = now();
        $lottery->save();

        (new LotteryDrawWebhook($lottery, $drawnNumbers,$winnerTickets, $winnersPercentage))->send();

        return redirect()
            ->back();
    }
}
