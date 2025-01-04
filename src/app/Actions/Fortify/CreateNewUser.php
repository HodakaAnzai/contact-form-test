<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Redirect;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input)
    {

        $request = new AuthRequest();
        $request->merge($input);
        $validated = $request->validate($request->rules());

        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    }
}
