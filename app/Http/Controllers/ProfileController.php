<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Role;

class ProfileController extends Controller
{
    public function im(){
        return Inertia::render('Profile/Edit',[
            'role'=>Role::get()
        ]);
    }
    public function imChange(ProfileUpdateRequest $request){
        $request->change();
        return back()->with('message', "Data Berhasil di Ubah");
    }
}
