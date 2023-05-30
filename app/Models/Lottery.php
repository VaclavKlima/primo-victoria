<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lottery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'maximum_tickets_per_player',
        'start_date',
        'end_date',
        'starting_price',
        'current_price',
        'ticket_price',
        'owner_name'
    ];

    protected array $dates = [
        'start_date',
        'end_date',
    ];
}
