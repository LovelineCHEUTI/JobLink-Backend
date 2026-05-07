<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'starts_at'  => 'date',
        'expires_at' => 'date',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helpers
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at->isFuture();
    }
}