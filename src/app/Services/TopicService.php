<?php

namespace App\Services;

use App\Models\Topic;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
class TopicService
{
    public function all(): Collection
    {
        return Topic::all();
    }

    public function listPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Topic::latest()->paginate($perPage);
    }

    public function create(array $data): Topic
    {
        $data['slug'] = Str::slug($data['name']);

        return Topic::create($data);
    }

    public function update(Topic $topic, array $data): Topic
    {
        $data['slug'] = Str::slug($data['name']);

        $topic->update($data);

        return $topic;
    }

    public function delete(Topic $topic): void
    {
        $topic->delete();
    }

}
