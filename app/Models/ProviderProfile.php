<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'is_validated',
        'average_rating',
        'reviews_count',
    ];

    protected $casts = [
        'is_validated'   => 'boolean',
        'average_rating' => 'float',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}