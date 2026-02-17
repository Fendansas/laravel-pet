<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class ItemsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        return new Item([
            'title'         => $row['title'],
            'description'   => $row['description'],
            'image'         => $row['image'],
            'price'         => $row['price'],
            'department_id'=> $row['department_id'],
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
