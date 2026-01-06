<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\UserPhotoService;
class UserPhotoController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected UserPhotoService $service
    ){}

    public function index(){
        $photos = $this->service->getForAuthUser();

        return view('user-photos.index', compact('photos'));
    }

    public function store(Request $request){
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $this->service->uploadPhotos($request->file('photos'));

        return redirect()->back()->with('success', 'Photos successfully uploaded');
    }

    public function destroy(UserPhoto $userPhoto){

        $this->authorize('delete', $userPhoto);

        $this->service->deletePhoto($userPhoto);

        return redirect()->back()->with('success', 'Photos successfully deleted');
    }
    public function show(User $user){

        $photos = $this->service->getForUser($user);

        return view('user-photos.show', compact('photos', 'user'));
    }
}
