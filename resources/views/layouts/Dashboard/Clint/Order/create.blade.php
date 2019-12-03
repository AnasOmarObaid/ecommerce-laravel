@extends('layouts.Dashboard.app')
@section('app')
<!-- Content Header (Page header) -->
<div class="content-header">
    @if (session()->get('successfully'))
    <div class="noti-message alert-success"><i class="far fa-check-circle" style="font-size: 14px;"></i>
        {{session()->get('successfully')}}
    </div>
    @endif
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 text-dark">Add Order</h2>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item">Orders</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
    <section class="order-content">
        <div class="row">

            <div class="col-md-6">
                <!-- department list -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i>
                            Departments List
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($departments) <= 0 ) <p class=" alert alert-danger">There Is No Departments To Add
                            Orders
                            </p>
                            @else
                            @foreach ($departments as $department)
                            {{-- Departments List --}}
                            <div class="card card-info">
                                <div class="card-header" data-toggle="collapse"
                                    href="#{{str_replace(' ', '-', $department->name)}}" role="button"
                                    aria-expanded="false" aria-controls="1" style="cursor:pointer">
                                    <h3 class="card-title"> {{$department->name}}</h3>
                                </div>
                                <div class="collapse" id="{{str_replace(' ', '-', $department->name)}}">
                                    <div class="card-body">
                                        @if ($department->getProducts()->count() == 0)
                                        <p class="alert alert-danger">There Is No Product</p>
                                        @else
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Stock</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Add</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($department->getProducts()->where('stock', '>',
                                                1)->where('status',1)->get() as
                                                $product)
                                                <tr id="product-{{$product->id}}">
                                                    <td><span>{{$product->name}}</span></td>
                                                    <td><span
                                                            id="stock-product{{$product->id}}">{{$product->stock}}</span>
                                                    </td>
                                                    <td><span class="span-price">{{$product->sale_price}}</span></td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-success product-data"
                                                            id="link-product{{$product->id}}"
                                                            data-name="{{$product->name}}" data-id="{{$product->id}}"
                                                            data-price="{{$product->sale_price}}"
                                                            data-quantity="{{$product->stock}}">
                                                            <i class="fas fa-plus fa-fw"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- End Departments List --}}
                            @endforeach
                            @endif
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- End department list -->
            </div>

            <div class="col-md-6">
                <!-- order list -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i>
                            Order List
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="order-submit" method="POST" action="{{route('client.store.order', $user_id)}}">
                            @csrf
                            @method('PUT')
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"><span>product</span></th>
                                        <th scope="col"><span>Quantity</span></th>
                                        <th scope="col"><span>Price</span></th>
                                    </tr>
                                </thead>
                                <thead class="table-head">

                                </thead>
                            </table>
                            <h5 style="margin-top:12px">Total: <span id="total-price"></span></h5>
                            <button type="submit" class="btn btn-info btn-block disabled btn-submit">Add
                                Product</button>
                        </form>
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- End order list -->
            </div>
        </div>
        <!-- order previous list -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar"></i>
                            order previous list
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($orders) == 0)
                        <p class="alert alert-danger">There Is No Orders For This Client</p>
                        @else
                        @foreach ($orders as $index=>$order)
                        <div class="card card-info">
                            <div class="card-header" data-toggle="collapse" href="#order{{$order->id}}" role="button"
                                aria-expanded="false" aria-controls="1" style="cursor:pointer">
                                Order Number {{$index}}
                            </div>

                            <div class="collapse" id="order{{$order->id}}">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <td>Name</td>
                                            <td>total price</td>
                                            <td>Quantity</td>
                                            <td>Date</td>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$order->getProduct()->first()->name}}</td>
                                                <td>{{$order->total_price}}</td>
                                                <td>{{$order->quantity}}</td>
                                                <td>{{$order->created_at->toFormattedDateString()}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- End order previous list -->
            </div>
        </div>
    </section>
</div>
@endsection