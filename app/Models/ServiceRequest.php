<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'provider_id',
        'title',
        'description',
        'location',
        'desired_date',
        'status',
    ];

    protected $casts = [
        'desired_date' => 'date',
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}