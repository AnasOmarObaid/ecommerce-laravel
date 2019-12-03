@extends('layouts.Dashboard.app')
@section('app')
{{-- Notfication  --}}
@if (session()->get('successfully'))
<div class="noti-message alert-success"><i class="far fa-check-circle" style="font-size: 14px;"></i>
    {{session()->get('successfully')}} </div>
@endif
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 text-dark">@lang('site.order')</h2>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item">@lang('site.order')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- End Header Contint(Page header) -->

<!--  Start Contint -->
<div class="container-fluid">
    <section class="order-content">
        <div class="row">
            <div class="col-md-7">
                <!-- Client list -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 6px;font-size: 20px; margin-right:10px">
                            <i class="far fa-chart-bar"></i>
                            Client List
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                        {{-- Form --}}
                        <form class="col-md-9 form-inline">
                            <div class="form-group">
                                <input type="search" class="form-control" name="search" placeholder="Search" required
                                    value="{{request('search') ?? ''}}">
                            </div>
                            <div class="float-right" style="margin-left:5px">
                                <button type="submit" class="btn btn-success"> <i class="fas fa-search fa-fw"></i>
                                    Search</button>
                            </div>
                        </form>
                        <!-- /.End Form -->
                    </div>
                    {{-- Client List --}}
                    <div class="card-body">
                        @if (count($orders) <= 0 ) <p class=" alert alert-danger">There Is No Orders</p>
                            @else
                            <table class="table table-hover">
                                <thead>
                                    <th>Client Name</th>
                                    <th>Price</th>
                                    <th>Add at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{$order->getUser()->first()->first_name . ' '. $order->getUser()->first()->last_name}}
                                        </td>
                                        <td><span class="span-price">{{$order->total_price}}</span></td>
                                        <td>{{$order->created_at->toFormattedDateString()}}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info get-order"
                                                data-name="{{$order->getProduct()->first()->name}}"
                                                data-quantity="{{$order->quantity}}"
                                                data-price="{{$order->getProduct()->first()->sale_price}}"
                                                data-total="{{$order->total_price}}">
                                                <i class="fas fa-shopping-basket fa-fw">
                                                </i> Show
                                            </a>
                                            @if (auth()->user()->can('update-orders'))
                                            <form action="{{route('order.edit', $order)}}" style="display:inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-warning"
                                                    style="color:white"><i class="fas fa-store-alt fa-fw"></i>
                                                    Edit</button>
                                            </form>
                                            @else
                                            <a href="#" class="btn btn-sm btn-warning disabled" style="color:white"><i
                                                    class="fas fa-store-alt fa-fw"></i> Edit</a>
                                            @endif
                                            @if (auth()->user()->can('delete-orders'))
                                            <form action="{{route('order.destroy', $order)}}" class="destroy-order"
                                                style="display:inline-block" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger btn-checked"><i
                                                        class="far fa-trash-alt fa-fw"></i>
                                                    Delete</button>
                                            </form>
                                            @else
                                            <a href="#" class="btn btn-sm btn-danger disabled"><i
                                                    class="far fa-trash-alt fa-fw"></i>
                                                Delete</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="margin-top:15px">
                                {{ $orders->appends(['search' => request('search')])->links()}}
                            </div>
                            @endif
                    </div>
                    {{-- End Client List --}}
                </div>
                <!-- End Client list -->
            </div>

            <div class="col-md-5">
                <!-- Order list -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 6px;font-size: 20px; margin-right:10px">
                            <i class="far fa-chart-bar"></i>
                            Order List
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="order-data">
                    </div>
                    <!-- /.card-body-->
                </div>
                <!-- End Order list -->
            </div>
        </div>

    </section>
</div>
<!--  End Content -->

@endsection