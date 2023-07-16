@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">User Profile</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('userProfile')}}">Profile</a></li>
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
                            <h4 class="card-title">User Profile</h4>
                            <p class="card-description">This is a user profile </p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 text-md-right text-sm-right text-lg-right ">
                            <a href="/editUser?id={{Auth::user()->id}}">
{{--                                <form class="forms-sample" method="POST" action="{{ route('editUser') }}">--}}
{{--                                    {{ csrf_field() }}--}}
{{--                                    <input id="id" type="hidden" class="form-control" name="id" value="{{ Auth::user()->id }}" required >--}}
                                <button type="button"
                                        class="btn btn-icon-text mb-3  mb-sm-0 btn-inverse-primary font-weight-normal">
                                    <i class="mdi mdi-account-edit btn-icon-prepend"></i>Edit
                                </button>
                                </a>
                        </div>
                    </div>
                    @if(!empty($users))
                        {{--                    <form class="forms-sample" method="POST" action="{{ route('') }}">--}}
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <img src="{{asset(!empty(Auth::user()->images) ? Auth::user()->images :'/images/face0.jpg')}}" class="img-thumbnail" alt="image" >
                            </div>
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="name"><b>{{__('Full Name')}}</b> </label>
                                            <input type="text" class="form-control-plaintext" id="name" name="name"  readonly
                                                   placeholder="Name" value="{{ $users->name }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="email"><b>{{__('E-mail')}}</b> </label>
                                            <input type="text" class="form-control-plaintext" id="email" name="email" readonly
                                                   placeholder="Email" value="{{ $users->email }}">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="address"><b>{{__('Address')}}</b> </label>
                                            <input type="text" class="form-control-plaintext" id="address" name="address" readonly
                                                   placeholder="Address" value="{{ $users->address }}">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="contact"><b>{{__('Contact')}}</b> </label>
                                            <input type="text" class="form-control-plaintext" id="contact" name="contact" readonly
                                                   placeholder="Contact" value="{{ $users->contact }}">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="type"><b>{{__('User Type')}}</b> </label>
                                            <input type="text" class="form-control-plaintext" id="type" name="type" readonly
                                                   placeholder="Contact" value="{{ $users->type }}">

                                        </div>
                                    </div>
{{--                                <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-content-save"></i> Save--}}
{{--                                </button>--}}
{{--                                <button class="btn btn-secondary"><i class="mdi mdi-close-circle-outline"></i> Close</button>--}}
                            </div>
                        </div>
{{--                    </form>--}}
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
