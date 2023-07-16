@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Change Password</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user')}}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Change Password</li>
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
                            <h4 class="card-title">Change Password</h4>
                            <p class="card-description">User can change himself password by this from </p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 text-sm-right text-md-right text-lg-right">
{{--                            <a href="{{route('user')}}">--}}
{{--                                <button type="button"--}}
{{--                                        class="btn btn-icon-text mb-3 ml-4 mb-sm-0 btn-inverse-primary font-weight-normal">--}}
{{--                                    <i class="mdi mdi-account-multiple btn-icon-prepend"></i> Goto User list--}}
{{--                                </button>--}}
{{--                            </a>--}}
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }} row">
                            <label for="new-password"
                                   class="col-md-4 control-label"><b>{{__('Current Password')}}</b></label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control"
                                       name="current-password" required>

                                @if ($errors->has('current-password'))
                                    <span class="text-danger">{{ $errors->first('current-password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} row">
                            <label for="new-password"
                                   class="col-md-4 control-label"><b>{{__('New Password')}}</b></label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="new-password"
                                       required>

                                @if ($errors->has('new-password'))
                                    <span class="text-danger">{{ $errors->first('new-password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new-password-confirm"
                                   class="col-md-4 control-label"><b>{{ __('Confirm New Password') }}</b></label>

                            <div class="col-md-6">
                                <input id="new-password-confirm" type="password" class="form-control"
                                       name="new-password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="mdi mdi-content-save"></i> {{ __('Change Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
