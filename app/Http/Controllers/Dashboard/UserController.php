<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\EmailRule;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {
        // read, create, update, delete
        $this->middleware(['permission:create-users'])->only(['create', 'insert']);
        $this->middleware(['permission:update-users'])->only(['edit', 'update']);
        $this->middleware(['permission:read-users|create:users|update-users|delete-users'])->only(['index']);
        $this->middleware(['permission:delete-users'])->only(['delete']);
    }
    // -- show the index page for user [show table]
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $user = User::where('id', '!=', auth()->user()->id)
                ->where('first_name', 'like', '%' .  $request->get('search') . '%')
                ->orWhere('last_name', 'like', '%' .  $request->get('search') . '%')->whereRoleIs('admin')->latest()->paginate(3);
        } else {
            $user = User::whereRoleIs('admin')->where('id', '!=', auth()->user()->id)->latest()->paginate(5);
        }
        return view('layouts.Dashboard.Users.index', ['users' => $user]);
    } // -- end index

    // -- show the form to insert new member
    public function create()
    {
        return view('layouts.Dashboard.Users.add');
    } // -- end create


    // -- insert new member
    public function insert(Request $request)
    {
        $request->validate([
            'first_name'    => ['string', 'required', 'max:255'],
            'last_name'    => ['string', 'required', 'max:255'],
            'email'    => ['email', 'unique:users'],
            'pass'  => ['required_with:con_pass', 'same:con_pass', 'min:6'],
            'image' => ['image', 'mimes:jpeg,bmp,png'],
        ]);
        $requestValidate = $request->except(['pass', 'con_pass', 'image', '_token', 'perm']);
        $requestValidate['password']    = Hash::make($request->get('pass'));
        if (request()->file('image')) {
            request()->validate([
                'image' => ['image', 'mimes:jpeg,bmp,png'],
            ]);
            $imageName = time() . '.' . request()->file('image')->getClientOriginalExtension();
            request()->file('image')->move(\base_path('public/data/upload/image/users'), $imageName); // move the image
            $requestValidate['image']   = $imageName; // save the image
        } // -- end if to check image
        $user =     User::create($requestValidate);
        $user->attachRole('admin');
        $user->syncPermissions($request->get('perm'));
        session()->flash('successfully', 'Successfully Addedd');
        return redirect('dashboard/user/show'); // return back will finish
    } // -- end insert


    // -- to show the edit view
    public function edit($id)
    {
        $user = User::where('id', $id)->get();
        return count($user) != 0 ? view('layouts.Dashboard.Users.edit', ['user' => $user]) : redirect('dashboard/home');
    } // -- end of edit


    // -- to update the user
    public function update($id, Request $request)
    {
        session()->put('id', $id);
        $request->validate([
            'first_name'    => ['string', 'required', 'max:255'],
            'last_name'    => ['string', 'required', 'max:255'],
            'email'    => ['email', new EmailRule($id, $request->get('email'))],
            'image' => ['image', 'mimes:jpeg,bmp,png'],
        ]);
        $user = User::where('id', $id)->get();
        $validateData = $request->except(['pass',  'image', '_token', 'perm']);
        // script to check and modify the images
        if (request()->hasFile('image')) { // if there is request then i should delete the old image if exist 
            request()->validate([
                'image' => ['image', 'mimes:jpeg,bmp,png'],
            ]);
            if ($user->first()->image) // check if this user has image to delete form file
                Storage::disk('image')->delete('data/upload/image/users/' . $user->first()->image); // remove the image for this user
            $imageName = time() . '.' . request()->file('image')->getClientOriginalExtension();
            request()->file('image')->move(\base_path('public/data/upload/image/users'), $imageName); // move the image
            $validateData['image'] = $imageName;
        } else { // if he want to update the image i must check if he have image or not
            if ($user->first()->image) {
                $validateData['image'] = $user->first()->image;
            }
        }
        // script to change and modify the password
        if (request()->get('pass')) {
            request()->validate([
                'pass'  => ['min:6'],
            ]);
            $validateData['password'] = Hash::make(request()->get('pass'));
        } else {
            $validateData['password'] = $user->first()->password;
        }

        $user->first()->update($validateData);
        $user->first()->syncPermissions($request->get('perm'));
        session()->flash('successfully', 'update Successfully ');
        return redirect('dashboard/user/show'); // return back will finish
    } // -- end update user

    // -- function to delete the user
    public function delete($id)
    {
        $user = User::whereRoleIs('admin')->where('id', $id)->get()->first();
        if ($user->image)
            Storage::disk('image')->delete('data/upload/image/users/' . $user->image); // remove the image for this user
        $user->delete();
        session()->flash('successfully', 'Delete Successfully');
        return back();
    } // -- end delete user
} // -- end user controller
