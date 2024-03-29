<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class LotteryPlayer extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(LotteryTicket::class);
    }

    public function lottery(): BelongsTo
    {
        return $this->belongsTo(Lottery::class);
    }

    public static function getUniquePlayers(): Collection
    {
        return self::query()
            ->select('name')
            ->groupBy('name')
            ->get()
            ->pluck('name');
    }
}
