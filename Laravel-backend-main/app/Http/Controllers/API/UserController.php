<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return User::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        //
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return $user;
    }
    public function update(UserRequest $request, string $id)
    {

        $User = User::findOrFail($id);

        $validated = $request->validated();

        $User->name = $validated['name'];

        $User->save();

        return $User;
    }
    public function email(UserRequest $request, string $id)
    {

        $User = User::findOrFail($id);

        $validated = $request->validated();

        $User->email = $validated['email'];

        $User->save();

        return $User;
    }
    public function password(UserRequest $request, string $id)
    {

        $User = User::findOrFail($id);

        $validated = $request->validated();

        $User->password = Hash::make($validated['password']);

        $User->save();

        return $User;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $User = User::findOrFail($id);

        $User->delete();

        return $User;
    }

     /**
     * Update the image of the specified resource from storage.
     */

    public function image(UserRequest $request, string $id)
    {
        $User = User::findOrFail($id);

        if (!is_null($User->image)){
            Storage::disk('public')->delete($User->image);
        };

        $User->image = $request->file('image')->storePublicly('images', 'public');

        $User->save();

        return $User;
    }

/**
     * Display a selection of the resource.
     */
    public function selection()
    {
        return User::select('id', 'name')
                        ->get();
    }

}
