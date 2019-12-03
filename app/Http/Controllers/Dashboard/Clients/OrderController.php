<?php

namespace App\Http\Controllers\Dashboard\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\Department;
use App\Order;
use App\Product;

class OrderController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $clientCount = Client::where('id', $id)->count();

        $departments = Department::where('status', 1)->get();

        $orders = Order::where('client_id', $id)->get();

        return $clientCount == 1 ? view('layouts.Dashboard.Clint.Order.create', ['departments' => $departments, 'user_id' => $id, 'orders' => $orders]) : \redirect('dashboard/home');
    } //-- end of create

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $client_id)
    {
        $product = new Product();

        foreach ($request->quantity as $products) {
            foreach ($products as $product_id => $quantity) {

                $product_find = $product->where('id', $product_id)->first();

                $price = $product_find->sale_price * $quantity; // -> 50 * 3 = 150

                $findOrder = Order::where([['client_id', $client_id], ['product_id', $product_id],])->first();

                if ($findOrder) {

                    $findOrder->update([
                        'quantity'      => $findOrder->quantity + $quantity, // -> 5 + 2 = 7
                        'total_price'   => $findOrder->total_price + $price, // -> 1200 + 150 = 1350
                    ]); //-- end update product 

                } else {
                    Order::create([

                        'product_id'    => $product_id,

                        'client_id'     => $client_id,

                        'quantity'      => $quantity,

                        'total_price'   => $price,

                    ]); //-- end of Create Order
                } //-- end if statement

                $product_find->update([
                    'stock'    => $product_find->stock - $quantity // -> 90 - 2 = 88
                ]); //-- end update the price

            }
        } //-- end of foreach

        session()->flash('successfully', 'Add Order Successfully');

        return back();
    } //-- end of store

}
