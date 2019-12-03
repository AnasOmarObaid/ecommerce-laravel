@extends('layouts.Dashboard.app')
@section('app')
<!-- Content Header (Page header) -->
<div class="content-header">
    <form method="POST" action="{{route('update.departments', $department->id)}}">
        @csrf
        @method('put')
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Department</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="{{route('show.department')}}">Department</a>
                        </li>
                        <li class="breadcrumb-item"> Edit </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
</div>

<div class="container">
    <div class="row" style="margin:auto">
        <div class="col-md-12">
            <div class="card" style="overflow: hidden;">
                <div class="card-header" style="background:#4a4a4a;color:#fff;">
                    Edit Deoartment
                </div>
                <div class="card-body">
                    @include('layouts._includes._error')
                    <div class="form-group">
                        <label>Department Name:</label>
                        <input type="text" id='name' class="form-control" placeholder="Enter Departemtn" name="name"
                            value="{{$department->name}}">
                    </div>

                    <div class="form-group">
                        <label>Department Description:</label>
                        <textarea class="form-control" name='description' required placeholder="Department Description"
                            style="height: 160px;">{{$department->description}}</textarea>
                    </div>
                    <hr />
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="create" value="block" name="status"
                            {{$department->status ? '' : 'checked'}}>
                        <label for="create" class="custom-control-label">Hide Department</label>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" style="margin-top:30px"><i
                            class="fas fa-user-plus fa-fw"></i>Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection