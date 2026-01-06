<?php

namespace App\Services\Event;

use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class EventResolver{

    public function findOrFail(int $id): Event{
        return Event::findOrFail($id);
    }

}
