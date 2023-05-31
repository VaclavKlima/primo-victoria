<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotteryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required'
            ],
            'start_date' => [
                'required',
                'date'
            ],
            'end_date' => [
                'required',
                'date'
            ],
            'maximum_tickets_per_player' => [
                'required',
                'integer'
            ],
            'starting_price' => [
                'required',
                'integer'
            ],
            'ticket_price' => [
                'required',
                'integer'
            ],
            'owner_name' => [
                'required'
            ],
            'chance_to_win' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
