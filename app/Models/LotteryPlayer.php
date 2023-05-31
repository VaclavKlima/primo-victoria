<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotteryPlayer extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(LotteryTicket::class);
    }
}
