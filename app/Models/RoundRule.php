<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoundRule extends Model
{
    use HasFactory;

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }
}
