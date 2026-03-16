<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Jobs\ExportItemsJob;
use App\Models\Department;
use App\Models\Item;
use App\Services\Item\ItemService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;


class ItemController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private ItemService $itemService){}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Item::class);

        $items = $this->itemService->paginate();

        $departments = Department::orderBy('name')->get();

        return view('items.index', compact('items', 'departments'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Item::class);

        $departments = Department::orderBy('name')->get();

        return view('items.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {

        $this->authorize('create', Item::class);


        $this->itemService->store($request->validated());

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $this->authorize('view', $item);

        $item->load('department');

        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $departments = Department::orderBy('name')->get();

        return view('items.edit', compact('item','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $this->authorize('update', $item);

        $this->itemService->update($request->validated(),$item);

        return redirect()->route('items.index')
            ->with('success','Item updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $this->itemService->delete($item);

        return back()->with('success','Item deleted');
    }

    public function import()
    {
        Excel::queueImport(new ItemsImport(), request()->file('file'));

        return back()->with('success','Items imported successfully');
    }

    public function export()
    {
        ExportItemsJob::dispatch(auth()->user());
        return back()->with('success','Экспорт запущен. Файл придет на email.');
    }

    public function download($file)
    {

        $path = storage_path('app/'.$file);

        if(!file_exists($path)){
            abort(404);
        }

        return response()->download($path);
    }
}
