<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//This is just to create a user for auth testing purposes, This would not be used in a real application
Route::get('/setup', function (Request $request) {
    $credentials = [
        'email' => 'admin5@admin.com',
        'password' => 'password',
    ];

    echo Auth::attempt($credentials);

    if (!Auth::attempt($credentials)) {
        // echo ('hello world');

        $user = new \App\Models\User();

        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);

        $user->save();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            //token that admin would use to give them all capabilities that they would use
            $adminToken = $request->user()->createToken('admin-token', ['create', 'update', 'delete']);
            $updateToken = $request->user()->createToken('update-token', ['create', 'update']);
            $basicToken = $request->user()->createToken('basic-token', ['none']); // if you don't define an ability, ie leave
            // the array blank, then your token will have all the abilities, So best to assign an ability and protect agains the mutable ones
            // so after giving the basic token the 'none' ability, the only thing we can do if we have a basic token in our Auth headers
            // is simply read, we can't create or update or delete (this is because we had not protected our requests agains the ability of 'none')
            // if we decided to protect all our requests against this ability then they would not be able to read

            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken,
            ];


        }

    }
});
