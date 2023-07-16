@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Manage Projects</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('project')}}">Project</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Project List</li>
            </ol>
        </nav>
    </div>
    <div class="panel-body">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body px-0 overflow-auto">
                    <div class="row mr-0">
                        <div class="col-sm-7 col-md-7 col-lg-6">
                            <h5 class="card-title pl-4">Project's Table</h5>
                            <p class="text-muted pl-4"> Show overview jan 2018 - Dec 2019 <a
                                    class="text-muted font-weight-medium pl-2" href="#"><u>See Details</u></a>
                            </p>
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-6 text-md-right">
                            @if(Auth::user()->type == 3)
                            <a href="{{route('project-add')}}">
                                <button type="button"
                                        class="btn btn-icon-text mb-3 ml-4 mr-4 mb-sm-0 btn-inverse-primary font-weight-normal">
                                    <i class="mdi mdi-plus-circle-outline btn-icon-prepend"></i>Add New
                                </button>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="bg-light">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Publish</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Created By IP</th>
                                <th class="pr-4">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($projects))
                                @foreach ($projects as $project)
                                    <tr>

                                        <td><h5><a href="/project-details?id={{$project->project_id}}">{{ $project->title}}</a></h5></td>
                                        <td>{{ Str::limit($project->description,100) }}</td>
                                        <td><span class=" badge badge-pill badge-primary">{{$project->status}}</span></td>
                                        <td>
                                            <form class="form-horizontal" method="POST"
                                                  action="{{ route('project-publish') }}">
                                                {{ csrf_field() }}
                                                <input id="id" type="hidden" class="form-control" name="id"
                                                       value="{{ $project->project_id }}" required>
                                                @if ( $project->isactive ==1)
                                                    <input id="status" type="hidden" class="form-control" name="status"
                                                           value="0" required>

                                                    <button type="submit" class=" badge badge-pill badge-inverse-success"><i
                                                            class="mdi mdi-account-check"></i> {{ __('Published') }}
                                                    </button>
                                                @else
                                                    <input id="status" type="hidden" class="form-control" name="status"
                                                           value="1" required>

                                                    <button type="submit" class=" badge badge-pill badge-inverse-danger "><i
                                                            class="mdi mdi-account-off"></i> {{ __('Draft') }}
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td><span class=" badge badge-pill badge-primary">{{$project->created_by}}</span>
                                        </td>
                                        <td>{{$project->created_at}}</td>
                                        <td>{{$project->created_by_ip}}</td>
                                        <td class="pr-4">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-outline-info dropdown-toggle"
                                                        id="dropdownMenuIconButton3" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton3">
                                                    <h6 class="dropdown-header">Settings</h6>
                                                    <a class="dropdown-item"
                                                       href="/project-edit?id={{$project->project_id}}"><i
                                                            class="mdi mdi-account-edit"></i> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#"><i class="mdi mdi-delete"></i>
                                                        Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9">
                                        No record found
                                    </td>
                                </tr>

                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
