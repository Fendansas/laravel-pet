<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'type',
        'color',
        'is_active',
        'description',
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
