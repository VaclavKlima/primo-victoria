<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\LotteryTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LotteryTicketsController extends Controller
{
    public function index(Lottery $lottery): JsonResponse
    {
        return response()->json([
           'tickets' => $lottery->players()->with('tickets')->get()
        ]);
    }

    public function store(Lottery $lottery, Request $request): JsonResponse
    {
        $player = $lottery->players()->firstOrCreate([
            'name' => $request->get('player_name'),
        ]);

        $ticketNumbers = $request->integer('number_of_tickets');
        $remainingTickets = $lottery->maximum_tickets_per_player - $player->tickets()->count();

        $ticketNumbers = min($ticketNumbers, $remainingTickets);

        if ($ticketNumbers <= 0) {
            return response()->json([
                'message' => 'You have already bought the maximum number of tickets.',
            ], 422);
        }

        $tickets = $lottery->tickets()->orderByDesc('ticket_number')->pluck('ticket_number');

        // generate a random number 1000000 - 9999999 that is not in the $tickets array with lottery->change_to_win chance
        $chanceToWin = $lottery->chance_to_win;

        // if chance to win is 50% then increment is 2
        $increment = 100 / $chanceToWin;
        $increment = round($increment, 2);

        $currentNumber = 10_000 - $increment;

        if ($tickets->count() > 0) {
            $currentNumber = $tickets->first();
        }

        foreach (range(1, $ticketNumbers) as $key) {
            $currentNumber += $increment;
            LotteryTicket::create([
                'lottery_id' => $lottery->id,
                'lottery_player_id' => $player->id,
                'ticket_number' => (int) $currentNumber,
            ]);
        }

        return response()->json([
            'message' => 'Tickets added successfully.',
        ]);
    }
}
