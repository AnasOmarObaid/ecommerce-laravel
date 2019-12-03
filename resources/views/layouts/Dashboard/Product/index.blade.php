@extends('layouts.Dashboard.app')
@section('app')
@if (session()->get('successfully'))
<div class="noti-message alert-success"><i class="far fa-check-circle" style="font-size: 14px;"></i>
    {{session()->get('successfully')}} </div>
@endif
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 text-dark">@lang('site.product')</h2>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item">@lang('site.product')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- End Header Contint(Page header) -->

<!-- main container -->
<div class="container-fluid">
    @if (auth()->user()->can(['create-products|delete-products|update-products|read-products']))
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="overflow: hidden;">
                <div class="card-header" style="position: relative">
                    <h3 class="card-title" style="margin-top: 6px;font-size: 20px">@lang('site.product_table')</h3>
                    @if (auth()->user()->can(['create-products']))
                    <a class="btn btn-success" href="{{route('create.products')}}"
                        style="cursor: pointer;float: right;"><i class="fas fa-plus-square fa-fw"></i>
                        @lang('site.add_product')</a>
                    @else
                    <a class="btn btn-success  disabled" href="#" style="cursor: pointer;float: right;"><i
                            class="fas fa-user-plus fa-fw"></i> @lang('site.add_member')</a>
                    @endif
                    <!-- SEARCH FORM -->
                    <form class="form-inline col-md-9" method="get">
                        <div class="form-group">
                            <select class="form-control" style="margin-right:20px" name="select">
                                <option value="all">Select The All Department</option>
                                @foreach ($departments as $department)
                                <option value="{{$department->id}}"
                                    {{request('select') == $department->id ? 'selected' : ''}}>{{$department->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search" style="border-right-width: thin;" name="search" max="20"
                                value="{{request('search') != NULL ? request('search') : ''}}" />
                        </div>

                        <button type="submit" class="btn btn-info" style="margin-left:10px"><i
                                class="fas fa-search fa-fw"></i> Select & Search</button>
                    </form>
                </div>
                <div class="card-body">
                    @if (count($products) <= 0) @lang('site.no_department') @else <table
                        class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <td>@lang('site.image')</td>
                                <td>@lang('site.name')</td>
                                <td>@lang('site.description')</td>
                                <td>@lang('site.department')</td>
                                <td>@lang('site.add_by')</td>
                                <td>@lang('site.purchase_price')</td>
                                <td>@lang('site.sale_price')</td>
                                <td>@lang('site.profit')</td>
                                <td>@lang('site.stock')</td>
                                <td>@lang('site.mange')</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0 ?>
                            @foreach ($products as $product)
                            <tr>
                                <th><span class="span-table">{{++$number}}</span></th>
                                <td><span class="span-table"><img
                                            src="{{asset('data\upload\image\products\\' . $product->image )}}"
                                            style="height: 50px;width: 50px;" alt="image"></span></td>
                                <td><span class="span-table">{{$product->name}}</span></td>
                                <td><span class="span-table">{{$product->description}}</span></td>
                                <td><span class="span-table">{{$product->getDepartment()->first()->name}}</span></td>
                                <td><span class="span-table">{{$product->getUser()->first()->email}}</span></td>
                                <td><span class="span-table">{{$product->purchase_price}}$</span></td>
                                <td><span class="span-table">{{$product->sale_price}}$</span></td>
                                <td><span class="span-table">{{$product->getProfit()}}$</span></td>
                                <td><span class="span-table">{{$product->stock}}</span></td>
                                <td>
                                    @if (auth()->user()->can(['update-products']))
                                    <a href="{{route('edit.products', $product->id)}}" style="margin-bottom:7px"
                                        class="btn btn-success btn-sm btn-block"><i class="far fa-edit fa-fw"></i>
                                        @lang('site.edit')
                                    </a>
                                    {{--  Check the product --}}
                                    @if ($product->status == 0)
                                    {{-- allow the prodcust --}}
                                    <form action="{{route('allow.products', $product->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" style="margin-bottom:7px"
                                            class="btn btn-sm btn-dark btn-block"><i class="fas fa-spinner fa-fw"></i>
                                            @lang('site.status')
                                        </button>
                                        {{-- End Check the product --}}
                                        @else
                                    </form>
                                    {{-- hide The Product --}}
                                    <form action="{{route('hide.products', $product->id)}}" method="POST">
                                        @csrf
                                        <button type="submit" style="margin-bottom:7px"
                                            class="btn btn-sm btn-info btn-info btn-block"><i
                                                class="fas fa-check fa-fw"></i> @lang('site.status')</button>
                                        @endif
                                    </form>
                                    {{-- Hide The Buttons --}}
                                    @else
                                    <a href="#" class="btn btn-success btn-sm disabled" style="margin-bottom:7px"><i
                                            class="fas fa-user-edit fa-fw"></i>
                                        @lang('site.edit')
                                    </a>
                                    <a style="margin-bottom:7px" href=""
                                        class="btn btn-sm btn-info btn-info btn-block disabled"><i
                                            class="fas fa-check fa-fw"></i> @lang('site.status')</a>
                                    @endif

                                    {{-- Delete Product --}}
                                    @if (auth()->user()->can(['delete-products']))
                                    <form method="post" action="{{route('delete.products', $product->id)}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm btn-block"
                                            data-toggle="modal" data-target="#example{{$number}}" style="color:white"><i
                                                class="far fa-trash-alt fa-fw"></i>
                                            @lang('site.delete')
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" tabindex="-1" role="dialog" id="example{{$number}}"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Products
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close" class="btn btn-danger btn-sm btn-block">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are You Soure To Delete {{$product->name}} <br>
                                                        This Will Lose The Data For This Product
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger btn-sm">Save
                                                            changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    @else
                                    <a class="btn btn-danger btn-sm disabled" href="#"><i
                                            class="fas fa-user-minus fa-fw"></i> @lang('site.delete')</a>
                                    @endif
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <div style="margin-top:15px">
                            {{ $products->appends(['select' => request()->get('select'), 'department_id' => request()->get('department_id') ,'search' => request()->get('search')])->links() }}
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container">
        <p class="alert alert-danger"> You Dont Have Permation To Created or See The Order </p>
    </div>
    @endif
</div>
<!-- end main container -->

@endsection