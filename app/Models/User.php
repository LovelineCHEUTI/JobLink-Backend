<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Category;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'city',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relations
    public function providerProfile()
    {
        return $this->hasOne(ProviderProfile::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sentRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'client_id');
    }

    public function receivedRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'provider_id');
    }
    public function categories()
    {
    return $this->belongsToMany(Category::class, 'provider_categories');
    }
}