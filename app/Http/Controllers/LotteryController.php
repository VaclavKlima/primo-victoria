<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotteryRequest;
use App\Models\Lottery;
use App\Webhooks\LotteryCreatedWebhook;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LotteryController extends Controller
{
    public function index(): View
    {
        return view('lotteries.index', [
            'lotteries' => Lottery::query()
                ->withCount('tickets')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('lotteries.form', [
            'lottery' => new Lottery(),
        ]);
    }

    public function store(LotteryRequest $request): RedirectResponse
    {
        $lottery = Lottery::create($request->validated());

        (new LotteryCreatedWebhook($lottery))->send();

        return redirect()
            ->route('lottery.index')
            ->with('success', 'Lottery created successfully.');
    }

    public function show(Lottery $lottery): View
    {
        return view('lotteries.show', [
            'lottery' => $lottery,
        ]);
    }

    public function edit(Lottery $lottery): View
    {
        return view('lotteries.form', [
            'lottery' => $lottery,
        ]);
    }

    public function update(LotteryRequest $request, Lottery $lottery): RedirectResponse
    {
        $lottery->update($request->validated());

        return redirect()
            ->route('lottery.index')
            ->with('success', 'Lottery updated successfully.');
    }

    public function destroy(Lottery $lottery): RedirectResponse
    {
        $lottery->delete();

        return redirect()
            ->route('lottery.index')
            ->with('success', 'Lottery deleted successfully.');
    }
}
