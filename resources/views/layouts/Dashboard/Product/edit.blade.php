@extends('layouts.Dashboard.app')
@section('app')
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
                    <li class="breadcrumb-item"><a href="{{url('dashboard/product/show')}}">@lang('site.product')</a>
                    </li>
                    <li class="breadcrumb-item">@lang('site.edit')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /- End Header Contint(Page header) -->
<!-- main container -->
<div class="container">
    <div class="row" style="margin:auto">
        <div class="col-md-12">
            <div class="card" style="overflow: hidden;">
                <div class="card-header" style="background:#4a4a4a;color:#fff;">
                    @lang('site.edit')
                </div>
                <div style="margin-top: 20px;margin-bottom: -20px;">
                </div>
                <div class="card-body">
                    @if (count($departments) == 0)
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">ops!</h4>
                        <p>@lang('site.error_no_edit_department')</p>
                        <hr>
                        <p class="mb-0">@lang('site.error_end')</p>
                    </div>
                    @else
                    @include('layouts._includes._error')
                    <form method="POST" enctype="multipart/form-data"
                        action="{{route('update.products', $product->id)}}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">To Department:</label>
                            <select class="form-control" id="exampleFormControlSelect1" name='department_id'
                                style="cursor:pointer" required>
                                <option disabled selected>Open this select menu</option>
                                @foreach ($departments as $department)
                                <option {{ $product->getDepartment()->first()->id == $department->id ? 'selected': ''}}
                                    value="{{$department->id}}"> {{$department->name}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">@lang('site.name'):</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"
                                value="{{$product->name}}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.description'):</label>
                            <textarea class="form-control" placeholder="Description" rows="3" style="height: 127px;"
                                name="description">{{$product->description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.purchase_price'):</label>
                            <input type="number" class="form-control" name="purchase_price"
                                value="{{$product->purchase_price}}" placeholder="Purchase Price" min="1" max="1000000">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.sale_price'):</label>
                            <input type="number" class="form-control" name="sale_price" value="{{$product->sale_price}}"
                                placeholder="Sale Price" min="1" max="1000000">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.stock'):</label>
                            <input type="number" class="form-control" name="stock" value="{{$product->stock}}"
                                placeholder="stock" min="1" max="1000000">
                        </div>

                        <!-- /.Mange -->
                        <div class="card card-primary card-outline" style="margin-top:30px">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    Mangement
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="permation-body">
                                    <div class="card card-primary card-outline card-outline-tabs">
                                        <div class="card-header p-0 border-bottom-0">
                                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-three-home-tab"
                                                        data-toggle="pill" href="#custom-tabs-three-home" role="tab"
                                                        aria-controls="custom-tabs-three-home"
                                                        aria-selected="true">Users</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-three-home"
                                                    role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="create" value="1" name="status"
                                                                    {{$product->status == 0 ? 'checked' : ''}} />
                                                                <label for="create" class="custom-control-label">Hide
                                                                    Product</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="read" value="1" name="allow_ads"
                                                                    {{$product->allow_ads == 1 ? 'checked' : ''}}>
                                                                <label for="read" class="custom-control-label">allow
                                                                    ads</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id='update' value="1" name="allow_commend"
                                                                    {{$product->allow_ads == 1 ? 'checked' : ''}}>
                                                                <label for="update" class="custom-control-label">allow
                                                                    commend</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.Mange -->
                        {{-- script image --}}
                        <div class="custom-file" style="margin-top: 20px;">
                            <label class="custom-file-label">@lang('site.chose_file')</label>
                            <input type="file" class="custom-file-input" name="image">
                            <small>if you leave this, the old image will still</small>
                        </div>
                        <button type="submit" class="btn btn-success btn-block" style="margin-top:30px"><i
                                class="fas fa-user-plus fa-fw"></i>@lang('site.edit')</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->
@endsection