<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function index(): View
    {
        return view('lotteries.index', [
            'lotteries' => Lottery::paginate(25),
        ]);
    }

    public function create(): View
    {

        return view('lotteries.form', [
            'lottery' => new Lottery(),
        ]);
    }

    public function store(Request $request)
    {
    }

    public function show(Lottery $lottery)
    {
    }

    public function edit(Lottery $lottery)
    {
    }

    public function update(Request $request, Lottery $lottery)
    {
    }

    public function destroy(Lottery $lottery)
    {
    }
}
