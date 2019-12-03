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
                <h2 class="m-0 text-dark">Edit Order</h2>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('order.index')}}">Orders</a></li>
                    <li class="breadcrumb-item">Edit Order</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container">
    <section class="order-content" style="margin:30px;margin-top:4%">
        <div class="row">
            <div class="col-md-12">
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
                        <form method="POST" action="{{route('order.update', $order)}}">
                            @csrf
                            @method('PUT')
                            <table class="table table-edit">
                                <thead>
                                    <tr>
                                        <th scope="col"><span>product</span></th>
                                        <th scope="col"><span>Quantity</span></th>
                                        <th scope="col"><span>Price</span></th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <td><span class="span">{{$order->getProduct()->first()->name}}</span></td>
                                        <td><input type="number" class="form-control input-sm edit-number"
                                                data-price="{{$order->getProduct()->first()->sale_price}}"
                                                name="quantity" min="1" max="{{$order->getProduct()->first()->stock}}"
                                                value="{{$order->quantity}}" style="width:60%"></td>
                                        <td><span
                                                class="span-price">{{$order->getProduct()->first()->sale_price}}</span><span>$</span>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <h5 style="margin-top:12px">Total: <span
                                    class="span-price total-edit-price">{{$order->total_price}}</span><span>$</span>
                            </h5>
                            <button type="submit" class="btn btn-info btn-block t">Edit
                                Product</button>
                        </form>
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- End order list -->
            </div>
        </div>
    </section>
</div>
@endsection