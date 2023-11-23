<?php

use App\Models\User;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Route;

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

Route::get('/index', function () {

    
    Benchmark::dd([
        fn () => \App\Models\User::all(), // 251.415ms, //232.551ms
        fn () => \App\Models\User::all(), // 204.010ms, //56.399ms
        fn () => \App\Models\User::toBase()->get(), //193.031 ms, //21.852ms
        fn () => \App\Models\User::toBase()->get('name'), //174.667 ms, 4.555ms
    ]);

    // return \App\Models\User::all()->dd();
});

Route::get('/sum', function () {

    Benchmark::dd([
        fn () => \App\Models\User::toBase()->sum('id'), //168.107ms
        function (){
            return \App\Models\User::get()->reduce(
                fn ($sum, $user) => $sum+$user->id,
                0
            );
        }, // 252.275ms
        function (){
            $sum = 0;
            foreach (\App\Models\User::toBase()->get() as $user){
                $sum += $user->id;
            }
            return $sum;
        } //193.545ms
    ]);

});

Route::get('/join', function (){
    Benchmark::dd([
        fn () => User::with('designation')->get(), //287.068ms
        fn () => User::join('designations', 'designations.id', 'users.designation_id')->get(), //249.523ms
    ], 1);
});
