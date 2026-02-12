<?php
namespace App\Services\Item;

use App\Models\Item;
use Illuminate\Pagination\LengthAwarePaginator;

final class ItemService
{
    public function paginate(int $perPage=10): LengthAwarePaginator{
        return Item::with('department')->paginate($perPage);
    }

    public function store(array $data): Item
    {

        if(isset($data['image'])){
            $data['image'] = $data['image']->store('items', 'public');
        }

        return Item::create($data);
    }

    public function update(array $data, Item $item): Item
    {
        if(isset($data['image'])){
            $data['image'] = $data['image']->store('items', 'public');
        }
        $item->update($data);

        return $item->fresh('department');
    }

    public function delete(Item $item): void
    {
        $item->delete();
    }

}
