<?php

namespace App\Http\Controllers\Dashboard;

use App\Department;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    /*
    
        make middleweare for function
    
    */

    public function __construct()
    {
        $this->middleware(['permission:create-products'])->only(['create', 'store', 'index']);

        $this->middleware('permission:update-products')->only(['edit', 'update', 'index']);

        $this->middleware('permission:delete-products')->only(['destroy', 'index']);

        $this->middleware(['permission:read-products'])->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get the departments to show on select
        $departments = Department::where('status', '1')->get(['name', 'id']);
        // variable to products
        $products = '';
        // search and select the products
        if ($request->get('select')) {
            if ($request->get('search')) {
                // select with search
                $request->get('select') == 'all' ? $products = Product::where('name', 'like', '%' . $request->get('search') . '%')->latest()->paginate(3) : $products = Product::where([
                    ['name', 'like', '%' . $request->get('search') . '%'],
                    ['department_id', $request->get('select')]
                ])->latest()->paginate(3);
            } else {
                // Select Without Search
                $request->get('select') == 'all' ? $products = Product::latest()->paginate(3) : $products = Product::where('department_id', $request->get('select'))->latest()->paginate(3);
            }
        } else {
            // no select and search
            $products = Product::latest()->paginate(3);
        } //-- end search and select the products

        // check if i want the product from department set
        if ($request->get('department_id'))
            $products = Product::where('department_id', $request->get('department_id'))->latest()->paginate(3);
        return view('layouts.Dashboard.Product.index', ['departments' => $departments, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //-- create function
    public function create()
    {
        $departments = Department::where('status', 1)->get();
        return view('layouts.Dashboard.Product.create', ['departments' => $departments]);
    } //-- end function

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    //-- store function
    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'min:3', 'max:20', Rule::unique('products')->where(function ($query) use ($request) {
                return $query->where('user_id', auth()->user()->id);
            })],
            'department_id' => ['required', 'integer'],
            'description'   => ['required', 'string', 'min:3', 'max:400'],
            'purchase_price'    => ['min:1', 'max:20000'],
            'sale_price'    => ['min:1', 'max:20000'],
            'stock'    => ['min:1', 'max:20000'],
        ], [], [
            'name'  => 'Product Name',
            'department_id' => 'Department',
        ]); //-- end validation
        $validateData = $request->except(['_token', '_method']);
        $validateData['user_id']    = auth()->user()->id;

        //-- script to add image
        if (request()->file('image')) {

            $request->validate([
                'image' => ['image', 'mimes:jpeg,bmp,png', 'max:500000'],
            ]);

            $imageName  = time() . '.' . request()->file('image')->getClientOriginalExtension();

            $validateData['image'] = $imageName;

            $request->file('image')->move(public_path('data/upload/image/products'), $imageName); // move the image

        } //-- end image check

        Product::create($validateData);

        session()->flash('successfully', 'Add Successfully Product');

        return \back();
    } //-- end store


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departments = Department::where('status', 1)->get();
        $product = Product::where('id', $id)->get()->first();
        return view('layouts.Dashboard.Product.edit', ['product' => $product, 'departments' => $departments,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->get()->first();

        $requestValidate = $request->except(['_token', '_method', 'image']);

        $request->validate([
            'name'  => ['required', 'string', 'min:3', 'max:20', Rule::unique('products')->where(function ($query) use ($request, $id, $product) {
                return $query->where([['user_id', $product->user_id], ['id', '!=', $id]]);
            })],

            'department_id' => ['required', 'integer'],
            'description'   => ['required', 'string', 'min:3', 'max:400'],
            'purchase_price'    => ['min:1', 'max:20000'],
            'sale_price'    => ['min:1', 'max:20000'],
            'stock'    => ['min:1', 'max:20000'],
        ], [], [
            'name'  => 'Product Name',
            'department_id' => 'Department',
        ]); //-- end validation

        //-- script image
        if ($request->file('image')) {

            $request->validate([
                'image' => ['image', 'mimes:jpeg,bmp,png', 'max:500000'],
            ]);

            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();

            //-- this product have image so i will delete the old one
            if ($product->image != 'default.png')
                Storage::disk('image')->delete('data/upload/image/products/' . $product->image);

            //-- add new image
            $request->file('image')->move(public_path('data/upload/image/products'), $imageName);

            //-- add this image in array to update it
            $requestValidate['image'] = $imageName;
        } //-- end script image

        $product->update($requestValidate);

        session()->flash('successfully', 'Update This Product Done !');

        return redirect()->route('show.products');
    }
    public function hideProduct($id)
    {
        $product = Product::where('id', $id)->get()->first();
        $product->update([
            'status'    => 0,
        ]);
        session()->flash('successfully', 'Hide This Product Done !');
        return \back();
    } //-- end status function

    public function allowProduct($id)
    {
        $product = Product::where('id', $id)->get()->first();
        $product->update([
            'status'    => 1,
        ]);
        session()->flash('successfully', 'Show This Product Done !');
        return \back();
    } //-- end status function
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product =  Product::where('id', $product)->get()->first();
        //-- delete the image
        if ($product->image != 'default.png')
            Storage::disk('image')->delete('data/upload/image/products/' . $product->image);
        $product->delete();
        session()->flash('successfully', 'Delete Product Successfully !');
        return back();
    }
}
