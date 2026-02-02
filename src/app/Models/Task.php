<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'department_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'deadline',
        'completed_at',
        'price',
        'is_paid',
    ];

    protected $casts = [
        'deadline'     => 'datetime',
        'completed_at' => 'datetime',
        'price'        => 'decimal:2',
        'is_paid'      => 'boolean',
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function assignedTo() {
        return $this->belongsTo(EventParticipant::class, 'assigned_to');
    }
}
