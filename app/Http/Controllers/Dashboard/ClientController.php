<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:update-clients')->only(['edit', 'update', 'index']);
        $this->middleware('permission:delete-clients')->only(['destroy', 'index']);
        $this->middleware(['permission:read-clients'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //-- index function
    public function index(Request $request)
    {
        $clients = Client::when($request->get('search'), function ($q) use ($request) {
            return $q->where('first_name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('last_name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('email', 'like', '%' . $request->get('search') . '%')
                ->orWhere('phone', 'like', '%' . $request->get('search') . '%');
        })->latest()->paginate(3);
        return view('Layouts.Dashboard.Clint.index', ['clients' => $clients]);
    } //-- end function

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => ['required', 'string', 'max:15', 'min:3'],
            'last_name'    => ['required', 'string', 'max:15', 'min:3'],
            'email'        => ['required', 'email', 'unique:clients'],
            'password'     => ['required', 'max:15', 'min:3'],
            'address'      => ['min:5', 'max:100'],
        ]);
        $requestValidate = $request->except('_token', '_method', 'image');
        //-- script to add image
        if (request()->file('image')) {
            $request->validate([
                'image' => ['image', 'mimes:jpeg,bmp,png', 'max:500000'],
            ]);
            $imageName  = time() . '.' . request()->file('image')->getClientOriginalExtension();
            $requestValidate['image'] = $imageName;
            $request->file('image')->move(public_path('data/upload/image/clients'), $imageName); // move the image
        } //-- end image Script
        Client::create($requestValidate);
        session()->flash('successfully', 'Successfully Added Client');
        return \back();
    } //-- end of create


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = Client::find($id);
        return $clients ? view('layouts.Dashboard.Clint.edit', ['client' => $clients]) : \redirect('dashboard/home');
    } //-- end of edit

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::where('id', $id)->get()->first();
        $request->validate([
            'first_name'   => ['required', 'string', 'max:15', 'min:3'],
            'last_name'    => ['required', 'string', 'max:15', 'min:3'],
            'email'        => ['required', 'email', Rule::unique('clients')->ignore($id)],
            'password'     => ['required', 'max:15', 'min:3'],
            'address'      => ['min:5', 'max:100'],
        ]);
        $requestValidate = $request->except(['_token', '_method', 'image']);
        //-- script image
        if ($request->file('image')) {
            $request->validate([
                'image' => ['image', 'mimes:jpeg,bmp,png', 'max:500000'],
            ]);
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            //-- this client have image so i will delete the old one
            if ($client->image != 'default.png')
                Storage::disk('image')->delete('data/upload/image/clients/' . $client->image);
            //-- add new image
            $request->file('image')->move(public_path('data/upload/image/clients'), $imageName);
            //-- add this image in array to update it
            $requestValidate['image'] = $imageName;
        } //-- end script image
        $client->update($requestValidate);
        session()->flash('successfully', 'Successfully Updated Clients');
        return redirect()->route('show.clients');
    } //-- end of update

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client =  Client::where('id', $id)->get()->first();
        //-- delete the image
        if ($client->image != 'default.png')
            Storage::disk('image')->delete('data/upload/image/clients/' . $client->image);
        $client->delete();
        session()->flash('successfully', 'Successfully Delete Clients');
        return redirect()->route('show.clients');
    }
}
