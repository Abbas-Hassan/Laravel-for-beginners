<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request)
   {
     
    
    // dd($request);
    // $path = $request->file('avatar')->store('avatars','public');
     
    // auth()->user()->update(['avatar' => storage_path('app')."/$path"]);

    $oldAvatar = $request->user()->avatar;
    
    //  Storage::disk('public')->delete($oldAvatar);
    // dd($oldAvatar);
    $filePath = Storage::disk('public')->put('avatars', $request->file('avatar'));
    if ($oldAvatar= $request->user()->avatar){
        Storage::disk('public')->delete($oldAvatar);
    }
    auth()->user()->update(['avatar' => $filePath]);
   


    return redirect(route('profile.edit'))->with('message', 'Avatar updated successfully!');

   }

    public function generate(Request $request)
    {
        $result = OpenAI::images()->create([
                  'prompt' => "create a cool user avatar for user in tech world",
                  'n' => 1,
                  'size' => "256x256",
             ]);
             

        $content = file_get_contents($result->data[0]->url);
        $filename = str::random(25);
        Storage::disk('public')->put("avatars/$filename.jpg", $content);

        auth()->user()->update(['avatar' => "avatars/$filename.jpg"]);
        return redirect(route('profile.edit'))->with('message', 'Avatar updated successfully!');
    
    }
}
