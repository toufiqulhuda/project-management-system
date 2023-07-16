@extends('layouts.app')

@section('content')
    <div class="page-header flex-wrap">
        <h3 class="mb-0"> Hi, {{ Auth::user()->name }} welcome back!
            <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">{{ __('You are logged in!') }}</span>
        </h3>
        <div class="d-flex">
            {{--            <button type="button" class="btn btn-sm bg-white btn-icon-text border">--}}
            {{--                <i class="mdi mdi-email btn-icon-prepend"></i> Email--}}
            {{--            </button>--}}
            {{--            <button type="button" class="btn btn-sm bg-white btn-icon-text border ml-3">--}}
            {{--                <i class="mdi mdi-printer btn-icon-prepend"></i> Print--}}
            {{--            </button>--}}
{{--            <button type="button" class="btn btn-sm ml-3 btn-success"> Add User</button>--}}
        </div>
    </div>
    {{--<div class="container">--}}
    {{--    <div class="row justify-content-center">--}}
    {{--        <div class="col-md-8">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

    {{--                <div class="card-body">--}}
    {{--                    @if (session('status'))--}}
    {{--                        <div class="alert alert-success" role="alert">--}}
    {{--                            {{ session('status') }}--}}
    {{--                        </div>--}}
    {{--                    @endif--}}

    {{--                    {{ __('You are logged in!') }}--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}
    <div class="row">
{{--        <div class="col-xl-3 col-lg-12 stretch-card grid-margin">--}}
{{--            <div class="row">--}}
{{--        {{dd($data)}}--}}
                <div class="col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                    <div class="card bg-warning">
                        <div class="card-body px-3 py-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="color-card">
                                    <p class="mb-0 color-card-head">Pending</p>
                                    <h2 class="text-white"> {{$pendingProject}}</h2>
                                </div>
                                <i class="card-icon-indicator mdi mdi-basket bg-inverse-icon-warning"></i>
                            </div>
                            <h6 class="text-white">Projects</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                    <div class="card bg-danger">
                        <div class="card-body px-3 py-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="color-card">
                                    <p class="mb-0 color-card-head">Running</p>
                                    <h2 class="text-white"> {{$runningProject}}</h2>
                                </div>
                                <i class="card-icon-indicator mdi mdi-cube-outline bg-inverse-icon-danger"></i>
                            </div>
                            <h6 class="text-white">Projects</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3 pb-lg-0 pb-xl-3">
                    <div class="card bg-primary">
                        <div class="card-body px-3 py-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="color-card">
                                    <p class="mb-0 color-card-head">Done</p>
                                    <h2 class="text-white"> {{$doneProject}}</h2>
                                </div>
                                <i class="card-icon-indicator mdi mdi-briefcase-outline bg-inverse-icon-primary"></i>
                            </div>
                            <h6 class="text-white">Projects</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3 pb-lg-0 pb-xl-3">
                    <div class="card bg-success">
                        <div class="card-body px-3 py-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="color-card">
                                    <p class="mb-0 color-card-head">Cancelled</p>
                                    <h2 class="text-white">{{$cancelProject}}</h2>
                                </div>
                                <i class="card-icon-indicator mdi mdi-account-circle bg-inverse-icon-success"></i>
                            </div>
                            <h6 class="text-white">Projects</h6>
                        </div>
                    </div>
                </div>
        @if (Auth::user()->type == 3)
                <div class="col-xl-3 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3 pb-lg-0 pb-xl-3">
                    <div class="card bg-success">
                        <div class="card-body px-3 py-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="color-card">
                                    <p class="mb-0 color-card-head">Draft</p>
                                    <h2 class="text-white">{{$draftProject}}</h2>
                                </div>
                                <i class="card-icon-indicator mdi mdi-account-circle bg-inverse-icon-success"></i>
                            </div>
                            <h6 class="text-white">Projects</h6>
                        </div>
                    </div>
                </div>
        @endif
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection
