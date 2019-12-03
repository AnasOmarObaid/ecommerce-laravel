<?php

namespace App\Http\Controllers\Dashboard;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:create-departments|update-departments|delete-departments|write-departments'])->only('index');
        $this->middleware(['permission:create-departments'])->only(['insert']);
        $this->middleware(['permission:update-departments'])->only(['edit', 'update']);
    }
    // -- index function
    public function index(Request $request)
    {
        $departments = '';
        if ($request->get('search')) {
            $departments = Department::where('name', 'like', '%' .  $request->get('search') . '%')->latest()->paginate(5);
        } else {
            $departments = Department::latest()->paginate(4);
        } // -- end if
        return view('layouts.Dashboard.Departments.index', ['departments' => $departments]);
    } // -- end of index function

    // -- create function
    public function insert(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'unique:departments', 'string', 'max:20'],
            'description'  => ['required', 'string', 'max:200', 'min:8'],
        ]);
        $requestValidate = $request->except(['_token', '_method']);
        $requestValidate['user_id'] = auth()->user()->id;
        Department::create($requestValidate);
        session()->flash('successfully', 'Added Successfully');
        return \redirect()->route('show.department');
    } // -- end of create function


    // -- edit function
    public function edit($id)
    {
        $departments = Department::find($id);
        return $departments ? view('layouts.Dashboard.Departments.edit', ['department' => $departments]) : \redirect('dashboard/home');
    } // -- end edit function


    // -- update function
    public function update($id, Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', Rule::unique('departments')->ignore($id)],
            'description' => ['required', 'string', 'max:80', 'min:8'],
        ]);
        $requestValidate = $request->except(['_token', '_method', 'status']);
        $request->get('status') ?  $requestValidate['status'] = 0 : $requestValidate['status'] = 1;

        $departments = Department::find($id);
        $departments->update($requestValidate);
        session()->flash('successfully', 'Update Successfully');
        return \redirect()->route('show.department');
    } // -- end update function


    // -- delete function
    public function delete($id)
    {
        $departments = Department::find($id);
        $departments->delete();
        session()->flash('successfully', 'Delete Successfully');
        return \redirect()->route('show.department');
    } // -- end delete function
}
