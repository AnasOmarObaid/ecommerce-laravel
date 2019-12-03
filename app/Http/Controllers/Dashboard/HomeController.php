<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:admin|super_admin']);
    } //-- end __construct

    public function index()
    {
        $orders     = Order::count();

        $products   = Product::count();

        $users      = User::whereRoleIs('admin')->count();

        $clients    = Client::count();

        $sales      = Order::select(

            DB::raw('YEAR(created_at) as year'),

            DB::raw('MONTH(created_at) as month'),

            DB::raw('SUM(total_price) as total'),

        )->groupBy('month')->get();


        return view('layouts.Dashboard.home', compact('orders', 'products', 'users', 'clients'));
    } //-- end index function
}
