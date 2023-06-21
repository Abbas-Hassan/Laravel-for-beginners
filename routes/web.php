<?php

use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::patch('/profile/avatar',[AvatarController::class,'update'])->name('profile.avatar');
    Route::post('/profile/avatar/ai',[AvatarController::class,'generate'])->name('profile.avatar.ai');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




Route::get('/openai',function()
{
    $result = OpenAI::images()->create([
        'prompt' => "create user avatar for user with good graphics",
        'n' => 1,
        'size' => "256x256",
    ]);
    return response(['url' => $result->data[0]->url]);
    
    // echo $result['choices'][0]['text'];
 });

