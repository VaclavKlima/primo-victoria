<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LotteryTicket extends Model
{
    protected $fillable = [
        'lottery_id',
        'lottery_player_id',
        'ticket_number',
        'is_winner',
    ];

    protected $casts = [
        'is_winner' => 'boolean',
    ];

    public function lottery(): BelongsTo
    {
        return $this->belongsTo(Lottery::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(LotteryPlayer::class);
    }
}
