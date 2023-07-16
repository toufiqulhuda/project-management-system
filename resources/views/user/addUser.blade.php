@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Add User</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user')}}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Add User</li>
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
                            <h4 class="card-title">Add User</h4>
                            <p class="card-description">This is a user registration from </p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 text-sm-right text-md-right text-lg-right">
                            <a href="{{route('user')}}">
                                <button type="button"
                                        class="btn btn-icon-text mb-3 ml-4 mb-sm-0 btn-inverse-primary font-weight-normal">
                                    <i class="mdi mdi-account-multiple btn-icon-prepend"></i> Goto User list
                                </button>
                            </a>
                        </div>
                    </div>
                    <form class="forms-sample" method="POST" action="{{ route('registarUser') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name <i class="mdi mdi-multiplication"></i></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required
                                           placeholder="Name">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email address <i class="mdi mdi-multiplication"></i></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required
                                           placeholder="Email">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password <i class="mdi mdi-multiplication"></i></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required
                                           placeholder="Password">
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmed"> Confirm Password <i
                                            class="mdi mdi-multiplication"></i></label>
                                    <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" id="password_confirm"
                                           name="password_confirm" required placeholder="Password">
                                    @error('password_confirm')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type">User Type <i class="mdi mdi-multiplication"></i></label>

                            <select class="js-example-basic-single select2-hidden-accessible @error('type') is-invalid @enderror" id="type" name="type"
                                    style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                @if(!empty($userTypeList))
                                @foreach($userTypeList as $userType)
                                    <option value="{{$userType['roleid']}}">{{$userType['role_name']}}</option>
                                @endforeach
                                @else
                                    <option value="">No record found</option>
                                @endif
                            </select>

                            @error('type')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-content-save"></i> Save
                        </button>
                        <button class="btn btn-secondary"><i class="mdi mdi-close-circle-outline"></i> Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
