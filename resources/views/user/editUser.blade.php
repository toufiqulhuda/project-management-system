@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">User Profile</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user')}}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{Auth::user()->name}}</li>
            </ol>
        </nav>
    </div>
    <div class="panel-body">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h4 class="card-title">Edit User</h4>
                            <p class="card-description">Can edit user information </p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 text-md-right text-sm-right text-lg-right ">
                            <a href="{{route('user')}}">
                                <button type="button"
                                        class="btn btn-icon-text mb-3  mb-sm-0 btn-inverse-primary font-weight-normal">
                                    <i class="mdi mdi-account-multiple btn-icon-prepend"></i> Goto User List
                                </button>
                            </a>
                        </div>
                    </div>
                    @if(!empty($users))
                    <form class="forms-sample" method="POST" action="{{ route('editUser') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <img src="{{asset(!empty($users->images) ? $users->images : '/images/face0.jpg')}}" alt="image" class="img-thumbnail">
                            </div>
                            <div class="col-sm-8 col-md-8 col-lg-8">

                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="name"><b>{{__('Full Name')}}</b> <i class="mdi mdi-multiplication"></i></label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="name" name="name" required
                                                   placeholder="Name" value="{{ $users->name }}">
                                            @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="email"><b>{{__('E-mail')}}</b> <i class="mdi mdi-multiplication"></i></label>
                                            <input type="text" class="form-control-plaintext" id="email" name="email" readonly
                                                   placeholder="Email" value="{{ $users->email }}">
                                            @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="address"><b>{{__('Address')}}</b> <i class="mdi mdi-multiplication"></i></label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" required
                                                   placeholder="Address" value="{{ $users->address }}">
                                            @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="contact"><b>{{__('Contact')}}</b> <i class="mdi mdi-multiplication"></i></label>
                                            <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" required
                                                   placeholder="Contact" value="{{ $users->contact }}">
                                            @error('contact')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="type"><b>{{__('User Type')}}</b> <i class="mdi mdi-multiplication"></i></label>
                                            <select class="js-example-basic-single select2-hidden-accessible @error('type') is-invalid @enderror" id="type" name="type"
                                                    style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                                @if(count($userTypeList)>0)
                                                    @foreach($userTypeList as $userType)

                                                        <option value="{{$userType['roleid']}}" {{($users->type == $userType['roleid']) ? 'selected': ''}} >{{$userType['role_name']}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">No type found</option>
                                                @endif
                                            </select>

                                            @error('type')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                <input type="hidden" name="id" value="{{$users->id}}">
                                <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-content-save"></i> Save
                                </button>
                                <button class="btn btn-secondary"><i class="mdi mdi-close-circle-outline"></i> Close</button>
                            </div>
                        </div>
                    </form>
                    @else
                        <div class="alert alert-success">
                            No record found
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
