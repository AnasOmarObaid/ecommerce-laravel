@extends('layouts.Dashboard.app')
@section('app')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0 text-dark">@lang('site.client')</h2>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item"><a href="{{url('dashboard/client/show')}}">@lang('site.client')</a>
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
                    @include('layouts._includes._error')
                    <form method="POST" enctype="multipart/form-data" action="{{route('update.clients', $client->id)}}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="first_name">Firts_name:</label>
                            <input type="text" id="first_name" class="form-control" placeholder="Enter First Name"
                                name="first_name" value="{{$client->first_name}}">
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" class="form-control" placeholder="Enter Last Name"
                                name="last_name" value="{{$client->last_name}}">
                        </div>

                        <div class="form-group">
                            <label for="email">@lang('site.email'):</label>
                            <input type="email" id="email" class="form-control" placeholder="examole@email.com"
                                name="email" value="{{$client->email}}">
                        </div>

                        <div class="form-group">
                            <label for="password">@lang('site.password'):</label>
                            <input type="password" id="password" class="form-control" placeholder="Enter password"
                                name="password" value="{{$client->password}}">
                            <small>If Leave this field then the old password not update and will to be still</small>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="tel" id="phone" class="form-control" placeholder="xxx-xxx" name="phone"
                                value="{{$client->phone}}">
                        </div>
                        <div class="form-group" style="margin-top:12px">
                            <label for="dapartment">client Address:</label>
                            <textarea class="form-control" name='address' placeholder="client Full Address"
                                style="height: 140px;">{{$client->address}}</textarea>
                        </div>

                        {{-- script image --}}
                        <div class="custom-file" style="margin-top: 20px;">
                            <label class="custom-file-label">@lang('site.chose_file')</label>
                            <input type="file" class="custom-file-input" name="image">
                            <small>if you leave this, the old image will still</small>
                        </div>

                        <button type="submit" class="btn btn-success btn-block" style="margin-top:30px"><i
                                class="fas fa-plus-square fa-fw"></i>@lang('site.edit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->
@endsection