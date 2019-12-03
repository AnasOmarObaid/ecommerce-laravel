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
                <h2 class="m-0 text-dark">@lang('site.user')</h2>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item">@lang('site.user')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
    @if (auth()->user()->can(['create-users|delete-users|update-users|read-users']))
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="overflow: hidden;">
                <div class="card-header" style="position: relative">
                    <h3 class="card-title">@lang('site.user_table')</h3>
                    @if (auth()->user()->can(['create-users']))
                    <a class="btn btn-success btn-sm" href="{{url('dashboard/user/create')}}"
                        style="cursor: pointer;float: right;"><i class="fas fa-user-plus fa-fw"></i>
                        @lang('site.add_member')</a>
                    @else
                    <a class="btn btn-success btn-sm disabled" href="#"
                        style="float: inline-end;margin-bottom: -5px;margin-top: -5px; color:white; cursor:pointer"><i
                            class="fas fa-user-plus fa-fw"></i> @lang('site.add_member')</a>
                    @endif
                    <!-- SEARCH FORM -->
                    <form class="form-inline col-md-6" method="get" action="{{url('dashboard/user/show')}}">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search" style="border-right-width: thin;" name="search"
                                value="{{old('search')}}" />
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search" style="position: absolute;left: -20px;top: 8px;"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if (count($users) <= 0) @lang('site.no_user') @else <table
                        class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <td scope="col">@lang('site.image')</td>
                                <td scope="col">@lang('site.first_name')</td>
                                <td scope="col">@lang('site.last_name')</td>
                                <td scope="col">@lang('site.email')</td>
                                <td scope="col">@lang('site.action')</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0 ?>
                            @foreach ($users as $user)

                            <tr>
                                <th>{{++$number}}</th>
                                <td>
                                    @if ($user->image)
                                    <img src="{{asset('data\upload\image\users\\') . $user->image}}" alt="Image User"
                                        style="max-width: 50px;max-height: 50px;">
                                    @else
                                    <img src="{{asset('image\users\3926_images.jpg')}}" alt=" defult User"
                                        style="max-width: 50px;max-height: 50px;">
                                    @endif
                                </td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if (auth()->user()->can(['update-users']))
                                    <a href="{{url('dashboard/user/edit', $user->id)}}"
                                        class="btn btn-success btn-sm"><i class="fas fa-user-edit fa-fw"></i>
                                        @lang('site.edit')
                                    </a>
                                    @else
                                    <a href="#" class="btn btn-success btn-sm disabled"><i
                                            class="fas fa-user-edit fa-fw"></i>
                                        @lang('site.edit')
                                    </a>
                                    @endif
                                    @if (auth()->user()->can(['delete-users']))
                                    <form style="display:inline-block" method="post"
                                        action="{{route('delete', $user)}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#example{{$number}}" style="color:white"><i
                                                class="fas fa-user-minus fa-fw"></i>
                                            @lang('site.delete')
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" tabindex="-1" role="dialog" id="example{{$number}}"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Members
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close" class="btn-sm">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are You Soure To Delete {{$user->email}} <br>
                                                        This Will Lose The Data For This User
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
                            {{ $users->appends(['search' => request()->get('search')])->links() }}
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container">
        <p class="alert alert-danger"> You Dont Have Permation To Created or See The Users </p>
    </div>
    @endif
</div>
<!-- /.content-header -->
@endsection