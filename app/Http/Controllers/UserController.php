<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Users\UpdateProfileRequest;
use Carbon\Carbon;


class UserController extends Controller
{
    public function edit()
    {
        return view('users.edit')->with('user',auth()->user());
    }

    
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user-> update([
            'name' => $request->name,
            'dateofbirth' => $request->dateofbirth,
            'about' => $request->about,
        ]);
        
        return back()->with('success','Update successfully!');
    }
}