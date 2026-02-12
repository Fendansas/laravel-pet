<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'department_id',
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
