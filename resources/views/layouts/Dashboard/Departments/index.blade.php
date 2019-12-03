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
                <h2 class="m-0 text-dark">Department</h2>
                @include('layouts._includes._error')
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item">Department</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
    @if (auth()->user()->can(['create-departments|delete-departments|update-departments|read-departments']))
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="overflow: hidden;">
                <div class="card-header" style="position: relative">
                    <h3 class="card-title" style="margin-top: 6px;font-size: 20px">Departments Table
                    </h3>
                    @if (auth()->user()->can(['create-departments']))
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        style="cursor: pointer;float: right;" data-target="#exampleModalScrollable">
                        <i class="fas fa-plus-square fa-fw"></i> Add Department
                    </button>
                    <!-- SEARCH FORM -->
                    <form class="form-inline col-md-8" method="get" action="{{route('show.department')}}">
                        <div class="input-group">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search" style="border-right-width: thin;" name="search"
                                value="{{request('search')}}" required max="20" pattern="[a-z0-9]" />
                        </div>

                        <button type="submit" class="btn btn-info" style="margin-left:10px"><i
                                class="fas fa-search fa-fw"></i> Search</button>
                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width:1000px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add Department</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('create.departments')}}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        @include('layouts._includes._error')
                                        <div class="form-group">
                                            <label for="dapartment">Department Name:</label>
                                            <input type="text" class="form-control" name='name' value="{{old('name')}}"
                                                required id="exampleInputEmail1" aria-describedby="department"
                                                placeholder="Department">
                                            <small id="department" class="form-text text-muted">Ensure The The
                                                Department
                                                Name Must Uniqe.</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="dapartment">Department Descarption:</label>
                                            <textarea class="form-control" name='description' required
                                                placeholder="Department Description"
                                                style="height: 160px;">{{old('description')}}</textarea>
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
                            class="fas fa-user-plus fa-fw"></i> Add Department</a>
                    @endif
                </div>
                <div class="card-body">
                    @if (count($departments) <= 0) <p> Theres Is No Departments To Show </p>
                        @else <table class="table table-bordered text-center table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <td>Name</td>
                                    <td>Description</td>
                                    <td>Add By</td>
                                    <td>Product Count</td>
                                    <td>Products</td>
                                    <td>status</td>
                                    <td>created_at</td>
                                    <td>updated_at</td>
                                    <td>Mange</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0 ?>
                                @foreach ($departments as $department)

                                <tr>
                                    <th><span class="span-table">{{++$number}}</span></th>
                                    <td>
                                        <span class="span-table">{{$department->name}}</span>
                                    </td>
                                    <td><span class="span-table">{{$department->description}}</span></td>
                                    <td><span class="span-table">{{ $department->getUser()->first()->email }}</span>
                                    </td>
                                    <td><span class="span-table">{{ $department->getProducts->count() }}</span></td>
                                    <td><span class="span-table"><a
                                                href="{{route('show.products', ["department_id" => $department->id])}}"
                                                class="btn btn-success btn-sm">Products</a></span></td>
                                    <td>
                                        @if ($department->status == 1)
                                        <span class="span-table"> Allow </span>
                                        @else
                                        <span class="span-table"> Block </span>
                                        @endif
                                    </td>
                                    <td><span class="span-table">{{$department->created_at}}</span></td>
                                    <td><span
                                            class="span-table">{{$department->updated_at->toFormattedDateString()}}</span>
                                    </td>
                                    <td>
                                        @if (auth()->user()->can(['update-departments']))
                                        <a href="{{route('edit.departments', $department)}}"
                                            class="btn btn-success btn-sm btn-block" style="margin-bottom:9px">
                                            <i class="fas fa-edit fa-fw"></i>
                                            Edit
                                        </a>
                                        @else
                                        <a href="#" class="btn btn-success btn-sm disabled btn-block"><i
                                                class="fas fa-user-edit fa-fw"></i>
                                            Edit Departmment
                                        </a>
                                        @endif
                                        @if (auth()->user()->can(['delete-departments']))
                                        <form method="POST" action="{{route('delete.departments', $department->id)}}">
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
                                                                Department
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close" class="btn-sm">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are You Soure To Delete {{$department->name}} <br>
                                                            This Will Lose The Data For This Department
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
                            {{ $departments->appends(['search' => request()->get('search')])->links() }}
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
    @else

    <div class="container">
        <p class="alert alert-danger"> You Dont Have Permation To Created or See The Departments </p>
    </div>
    @endif
</div>
@endsection