@extends('layouts.Dashboard.app')
@section('app')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Member</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/home')}}">@lang('site.dash')</a></li>
                    <li class="breadcrumb-item active"><a href="{{url('dashboard/user/show')}}">@lang('site.user')</a>
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
                    @lang('site.add_member')
                </div>
                <div style="margin-top: 20px;margin-bottom: -20px;">
                    @if (session()->get('successfully'))
                    <p class="alert alert-primary" role="alert"><strong>!Note</strong>{{session()->get('successfully')}}
                    </p>
                    @endif
                </div>
                <div class="card-body">
                    @include('layouts._includes._error')
                    <form method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>@lang('site.first_name'): </label>
                            <input type="text" id='first_name' class="form-control" placeholder="Enter First Name"
                                name="first_name" value="{{$user->first()->first_name}}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.last_name'): </label>
                            <input type="text" class="form-control" placeholder="Enter Last Name" name="last_name"
                                value="{{$user->first()->last_name}}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email'): </label>
                            <input type="email" class="form-control" placeholder="name@gmail.com" name="email"
                                value="{{$user->first()->email}}">
                            <small>please enter correct email</small>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.password'): </label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="pass">
                            <small>If You kep this empety then the old password will not change</small>
                        </div>

                        <div class="custom-file">
                            <label class="custom-file-label" for="validatedCustomFile">@lang('site.chose_file')</label>
                            <input type="file" class="custom-file-input" name="image">
                        </div>

                        <!-- /.permaision -->
                        <div class="card card-primary card-outline" style="margin-top:30px">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    Permations
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
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-three-profile-tab"
                                                        data-toggle="pill" href="#custom-tabs-three-profile" role="tab"
                                                        aria-controls="custom-tabs-three-profile"
                                                        aria-selected="false">Department</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-three-messages-tab"
                                                        data-toggle="pill" href="#custom-tabs-three-messages" role="tab"
                                                        aria-controls="custom-tabs-three-messages"
                                                        aria-selected="false">Product</a>
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
                                                                    id="create" value="create-users" name="perm[]"
                                                                    {{$user->first()->can(['create-users']) ? 'checked' : ''}}>
                                                                <label for="create" class="custom-control-label">Created
                                                                    User</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="read" value="read-users" name="perm[]"
                                                                    {{$user->first()->can(['read-users']) ? 'checked' : ''}}>
                                                                <label for="read" class="custom-control-label">Read
                                                                    User</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id='update' value="update-users" name="perm[]"
                                                                    {{$user->first()->can(['update-users']) ? 'checked' : ''}}>
                                                                <label for="update" class="custom-control-label">Update
                                                                    User</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="delete" value="delete-users" name="perm[]"
                                                                    {{$user->first()->can(['delete-users']) ? 'checked' : ''}}>
                                                                <label for="delete" class="custom-control-label">Delete
                                                                    Users</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-three-profile"
                                                    role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                                    Mauris tincidunt mi at erat gravida, eget tristique urna bibendum.
                                                    Mauris pharetra purus ut ligula tempor, et vulputate metus
                                                    facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                                                    posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus
                                                    interdum, nisl ligula placerat mi, quis posuere purus ligula eu
                                                    lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere
                                                    nec nunc. Nunc euismod pellentesque diam.
                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-three-messages"
                                                    role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                                    Morbi turpis dolor, vulputate vitae felis non, tincidunt congue
                                                    mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus
                                                    faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac
                                                    tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum.
                                                    Suspendisse ut velit condimentum, mattis urna a, malesuada nunc.
                                                    Curabitur eleifend facilisis velit finibus tristique. Nam vulputate,
                                                    eros non luctus efficitur, ipsum odio volutpat massa, sit amet
                                                    sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida
                                                    fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel
                                                    metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare
                                                    magna.
                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-three-settings"
                                                    role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                                    Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque
                                                    magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget
                                                    blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod
                                                    molestie tristique. Vestibulum consectetur dolor a vestibulum
                                                    pharetra. Donec interdum placerat urna nec pharetra. Etiam eget
                                                    dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et
                                                    felis ut nisl commodo dignissim. In hac habitasse platea dictumst.
                                                    Praesent imperdiet accumsan ex sit amet facilisis.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.permaision -->
                        <button type="submit" class="btn btn-success btn-block" style="margin-top:30px"><i
                                class="fas fa-user-plus fa-fw"></i>Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection