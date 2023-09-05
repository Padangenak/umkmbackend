<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function current(){
        $user = User::with('role')->orderBy('id','DESC')->get();
        return Inertia::render('user/current', [
            'user'=>$user
        ]);
    }
    public function add(){
        $role = Role::get();
        return Inertia::render('user/add', [
            'role'=>$role
        ]);
    }
    public function addUser(UserRequest $request){
        $user = $request->add();
        return back()->with('message', "Adding Success");
    }
    public function currentActive($id){
        $user = User::find($id);
        User::find($id)->update([
            'active'=>$user->active == 'On' ? 'Off' : 'On'
        ]);

        return User::orderBy('id', 'DESC')->get();
    }
}
