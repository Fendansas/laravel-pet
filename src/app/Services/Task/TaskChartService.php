<?php
namespace App\Services\Task;

use App\Models\Task;
use Illuminate\Support\Facades\DB;


class TaskChartService
{
    public function byStatus()
    {
        return Task::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->get();
    }
}
