<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'setting';
        $submenu = 'users';
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.users.index', compact('users', 'menu', 'submenu'));
    }

    //create
    public function create()
    {
        $menu = 'setting';
        $submenu = 'users';
        return view('pages.users.create', compact('menu', 'submenu'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
            'stage' => 'required',
            'division' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->stage = $request->stage;
        $user->division = $request->division;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    //show detail
    public function show($id)
    {
        $menu = 'setting';
        $submenu = 'users';
        $user = User::find($id);
        return view('pages.users.show', compact('user', 'menu', 'submenu'));
    }

    //edit
    public function edit($id)
    {
        $menu = 'setting';
        $submenu = 'users';
        $user = User::find($id);
        return view('pages.users.edit', compact('user', 'menu', 'submenu'));
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
            'stage' => 'required',
            'division' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->stage = $request->stage;
        $user->division = $request->division;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->updated_at = now();
        $user->save();

        // UPLOAD PHOTO
        if ($request->hasFile('photo')) {
            //Delete last photo file if exists
            $file = $user->photo;
            if (File::exists(public_path($file))) {
                File::delete(public_path($file));
            }
            //Upload new photo
            $image = $request->file('photo');
            $image->storeAs('public/users', $user->id . '.' . $image->getClientOriginalExtension());
            $user->photo = 'storage/users/' . $user->id . '.' . $image->getClientOriginalExtension();
            $user->save();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    //destroy
    public function destroy($id)
    {
        $user = User::find($id);
        //delete file photo
        $file = $user->photo;
        if (File::exists(public_path($file))) {
            File::delete(public_path($file));
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    //profile
    public function profile($id)
    {
        $menu = 'setting';
        $submenu = 'profile';
        $profile = User::find($id);
        return view('pages.users.profile', compact('profile', 'menu', 'submenu'));
    }
    //update profile
    public function updateprofile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        $profile = User::find($id);
        //cek password
        if ($request->password) {
            if ($request->password == $request->password_confirm) {
                $profile->password = Hash::make($request->password);
            }
        }
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        $profile->updated_at = now();
        $profile->save();

        // UPLOAD PHOTO
        if ($request->hasFile('photo')) {
            //Delete last photo file if exists
            $file = $profile->photo;
            if (File::exists(public_path($file))) {
                File::delete(public_path($file));
            }
            //Upload new photo
            $image = $request->file('photo');
            $image->storeAs('public/users', $profile->id . '.' . $image->getClientOriginalExtension());
            $profile->photo = 'storage/users/' . $profile->id . '.' . $image->getClientOriginalExtension();
            $profile->save();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}