<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'owner_name',
        'chance_to_win',
        'drawn_at',
    ];

    protected array $dates = [
        'start_date',
        'end_date',
        'drawn_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'drawn_at' => 'datetime',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(LotteryTicket::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(LotteryPlayer::class);
    }
}
