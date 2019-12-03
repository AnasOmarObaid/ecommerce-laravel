<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::whereHas('getUser', function ($q) use ($request) {

            return $q->where('first_name', 'like', '%' . $request->search . '%')

                ->orWhere('last_name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(3);

        return view('layouts.Dashboard.Order.index', ['orders' => $orders]);
    } //-- end of index 


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('layouts.Dashboard.Order.edit', ['order' => $order]);
    } //-- end of edit


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $quantity = $request->get('quantity');

        $price    = $order->getProduct()->first()->sale_price;

        $new_stock = $order->quantity - $request->get('quantity');


        $order->getProduct()->first()->update([
            'stock' => $order->getProduct()->first()->stock + $new_stock,
        ]);

        $order->update([
            'quantity'      => $quantity,
            'total_price'   => $quantity * $price,
        ]);

        session()->flash('successfully', 'Update Order Successfully');
        return redirect()->route('order.index');
    } //-- end of update


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $product = $order->getProduct()->first();

        $product->update([
            'stock' => $product->stock + $order->quantity,
        ]);

        $order->delete();
        session()->flash('successfully', 'Delete Order Successfully');
        return \back();
    } //-- end of destroy

}//-- end of controller
