<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'notes',
        'earned_money',
        'photo',
    ];

    protected $casts = [
        'earned_money' => 'decimal:2',
    ];

    public function events(){
        return $this->belongsToMany(Event::class)
            ->withPivot(['role_in_event', 'joined_at'])
            ->withTimestamps();
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
