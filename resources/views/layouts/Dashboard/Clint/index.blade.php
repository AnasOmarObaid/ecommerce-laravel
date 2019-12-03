@extends('Layouts.Dashboard.app')
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
                <h2 class="m-0 text-dark">client</h2>
                @include('layouts._includes._error')
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item">client</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
    @if (auth()->user()->can(['create-clients|delete-clients|update-clients|read-clients']))
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="overflow: hidden;">
                <div class="card-header" style="position: relative">
                    <h3 class="card-title" style="margin-top: 6px;font-size: 20px">clients Table
                    </h3>
                    @if (auth()->user()->can(['create-clients']))
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        style="cursor: pointer;float: right;" data-target="#exampleModalScrollable">
                        <i class="fas fa-plus-square fa-fw"></i> Add client
                    </button>
                    <!-- SEARCH FORM -->
                    <form class="form-inline col-md-8" method="get" action="{{route('show.clients')}}">
                        <div class="input-group">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search" style="border-right-width: thin;" name="search"
                                value="{{request('search') ?? ''}}" required max="20" />
                        </div>

                        <button type="submit" class="btn btn-info" style="margin-left:10px"><i
                                class="fas fa-search fa-fw"></i> Search</button>
                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 925px;">
                            <div class="modal-content" style="overflow: auto;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add client</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {{-- Form Start --}}
                                <form action="{{route('store.clients')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        @include('layouts._includes._error')
                                        <div class="form-group">
                                            <label for="dapartment">client first Name:</label>
                                            <input type="text" class="form-control" name='first_name'
                                                value="{{old('first_name')}}" placeholder="First Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="dapartment">client Last Name:</label>
                                            <input type="text" class="form-control" name='last_name'
                                                value="{{old('last_name')}}" placeholder="Last Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="dapartment">client Email:</label>
                                            <input type="email" class="form-control" name='email'
                                                value="{{old('email')}}" placeholder="example@email.com">
                                        </div>

                                        <div class="form-group">
                                            <label for="dapartment">client password:</label>
                                            <input type="password" class="form-control" name='password'
                                                value="{{old('email')}}" placeholder="Enter Password">
                                        </div>

                                        <div class="form-group">
                                            <label for="dapartment">client Phone:</label>
                                            <input type="tel" class="form-control" name='phone' value="{{old('phone')}}"
                                                placeholder="Ex:xxx-xxx">
                                        </div>

                                        <div class="custom-file" style="margin-top: 15px;">
                                            <label class="custom-file-label">@lang('site.chose_file')</label>
                                            <input type="file" class="custom-file-input" name="image">
                                        </div>

                                        <div class="form-group" style="margin-top:15px">
                                            <label for="dapartment">client Address:</label>
                                            <textarea class="form-control" name='address'
                                                placeholder="client Full Address"
                                                style="height: 140px;">{{old('address')}}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">Save
                                            changes</button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-dismiss="modal">Close</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    @else
                    <a class="btn btn-success btn-sm disabled" href="#"
                        style="float: inline-end;margin-bottom: -5px;margin-top: -5px; color:white; cursor:pointer"><i
                            class="fas fa-user-plus fa-fw"></i> Add client</a>
                    @endif
                </div>
                <div class="card-body">
                    @if (count($clients) <= 0) <p> Theres Is No clients To Show </p>
                        @else <table class="table table-bordered text-center table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <td>Name</td>
                                    <td>Image</td>
                                    <td>Email</td>
                                    <td>Phone</td>
                                    <td>Orders</td>
                                    <td>Address</td>
                                    <td>created_at</td>
                                    <td>Mange</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0 ?>
                                @foreach ($clients as $client)

                                <tr>
                                    <th><span class="span-table">{{++$number}}</span></th>
                                    <td>
                                        <span class="span-table">{{$client->first_name . ' ' . $client->last_name}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="span-table"><img
                                                src="{{asset('data\upload\image\clients\\' . $client->image )}}"
                                                style="height: 50px;width: 50px;" alt="image">
                                        </span>
                                    </td>
                                    <td><span class="span-table"> {{$client->email}} </span></span>
                                    <td><span class="span-table"> {{$client->phone}} </span></td>
                                    <td>@if (auth()->user()->can('create-orders'))
                                        <span class="span-table"><a class="btn btn-info btn-sm"
                                                href="{{route('client.create.order', $client->id)}}">Add
                                                Order</a></span>
                                        @else
                                        <span class="span-table"><a class="btn btn-info btn-sm disabled" href="#">Add
                                                Order</a></span>
                                        @endif</td>
                                    <td><span class="span-table">{{$client->address}}</span></td>
                                    <td><span class="span-table">{{$client->created_at->toFormattedDateString()}}</span>
                                    </td>
                                    <td>
                                        @if (auth()->user()->can(['update-clients']))
                                        <a href="{{route('edit.clients', $client->id)}}"
                                            class="btn btn-success btn-sm btn-block" style="margin-bottom:9px">
                                            <i class="fas fa-edit fa-fw"></i>
                                            Edit
                                        </a>
                                        @else
                                        <a href="#" class="btn btn-success btn-sm disabled btn-block"><i
                                                class="fas fa-user-edit fa-fw"></i>
                                            Edit
                                        </a>
                                        @endif
                                        @if (auth()->user()->can(['delete-clients']))
                                        <form method="POST" action="{{route('delete.clients', $client->id)}}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm btn-block"
                                                style="margin-bottom:9px" data-toggle="modal"
                                                data-target="#example{{$number}}" style="color:white">
                                                <i class="fas fa-trash fa-fw"></i>
                                                @lang('site.delete')
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" tabindex="-1" role="dialog" id="example{{$number}}"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete
                                                                client
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close" class="btn-sm">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are You Soure To Delete {{$client->name}} <br>
                                                            This Will Lose The Data For This client
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
                                        <a class="btn btn-danger btn-sm disabled btn-block" href="#"><i
                                                class="fas fa-user-minus fa-fw"></i> @lang('site.delete')</a>
                                        @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="margin-top:15px">
                            {{ $clients->appends(['search' => request()->get('search')])->links() }}
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    @else

    <div class="container">
        <p class="alert alert-danger"> You Dont Have Permation To Created or See The clients </p>
    </div>
    @endif
</div>
@endsection