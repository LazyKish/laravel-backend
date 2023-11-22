<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update the image of the token bearer from resource.
     */

     public function image(UserRequest $request)
     {
         $User = User::findOrFail($request->user()->id);
 
         if (!is_null($User->image)){
             Storage::disk('public')->delete($User->image);
         };
 
         $User->image = $request->file('image')->storePublicly('images', 'public');
 
         $User->save();
 
         return $User;
     }

      /**
     * Display the specified information of the token bearer.
     */
    public function show(Request $request)
    {
        return $request->user();
    }

}
