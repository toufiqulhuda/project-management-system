@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Edit Role</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user-role')}}">Role</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Edit Role</li>
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
                            <h4 class="card-title">Edit Role</h4>
                            <p class="card-description">Edit role from </p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 text-sm-right text-md-right text-lg-right">
                            <a href="{{route('user-role')}}">
                                <button type="button"
                                        class="btn btn-icon-text mb-3 ml-4 mb-sm-0 btn-inverse-primary font-weight-normal">
                                    <i class="mdi mdi-account-multiple btn-icon-prepend"></i> Goto Role list
                                </button>
                            </a>
                        </div>
                    </div>
                    @if(!empty($role))
                    <form class="forms-sample" method="POST" action="{{ route('edit-role') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="name">{{__('Role Name')}} <i class="mdi mdi-multiplication"></i></label>
                                    <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" required value="{{$role->role_name}}"
                                           placeholder="role_name">
                                    @error('role_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="email">{{__('Description')}} <i class="mdi mdi-multiplication"></i></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="4" id="description" name="description" required
                                              placeholder="Description">{{$role->description}}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$role->roleid}}">
                        <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-content-save"></i> Save
                        </button>
                        <button class="btn btn-secondary"><i class="mdi mdi-close-circle-outline"></i> Close</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
