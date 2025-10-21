<?php

namespace App\Http\Controllers;

use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserPhotoController extends Controller
{
    use AuthorizesRequests;
    public function index(){

        $photos = auth()->user()->photos()->latest()->get();
        return view('user-photos.index', compact('photos'));
    }

    public function store(Request $request){
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        foreach($request->file('photos') as $photo){
            $path = $photo->store('user_photo', 'public');
            auth()->user()->photos()->create(['path' => $path]);
        }

        return redirect()->back()->with('success', 'Photos successfully uploaded');
    }

    public function destroy(UserPhoto $userPhoto){

        $this->authorize('delete', $userPhoto);

        Storage::disk('public')->delete($userPhoto->path); //  удаляем картинку
        $userPhoto->delete(); // удадяем запись с базы данных

        return redirect()->back()->with('success', 'Photos successfully deleted');
    }
}
