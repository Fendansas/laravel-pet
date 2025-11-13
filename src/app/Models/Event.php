<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'created_by',
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function participants(){
        return $this->belongsToMany(EventParticipant::class)
            ->withPivot('role_in_event', 'joined_at')
            ->withTimestamps();
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }


}
