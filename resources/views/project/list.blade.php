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
{{--                            <p class="text-muted pl-4"> Show overview jan 2018 - Dec 2019 <a--}}
{{--                                    class="text-muted font-weight-medium pl-2" href="#"><u>See Details</u></a>--}}
{{--                            </p>--}}
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
{{--                    <form class="forms-sample" method="post" action="{{ route('project-bulk-action') }}" enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        <div class="row mr-4">--}}
{{--                            <div class="col-auto">--}}
{{--                                <label for="assigned_to">Bulk Action </label>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto">--}}
{{--                                <select class="js-example-basic-single select2-hidden-accessible @error('assigned_to') is-invalid @enderror" required id="assigned_to" name="assigned_to"--}}
{{--                                        style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" >--}}
{{--                                    <option value="" >--Assign to--</option>--}}
{{--                                    <option value="0">Draft</option>--}}
{{--                                    <option value="1">Published</option>--}}
{{--                                </select>--}}
{{--                                @error('assigned_to')--}}
{{--                                <span class="text-danger">{{$message}}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="col-auto">--}}
{{--                                <button type="submit" class="btn btn-primary mb-3">Confirm</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Instruction</th>
                                <th>Status</th>
                                @if (Auth::user()->type == 2)
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Assigned To</th>
                                @elseif(Auth::user()->type == 3)
                                <th>Publish</th>
                                @elseif(Auth::user()->type == 4)
                                <th>Assigned By</th>
                                <th>Assigned At</th>
                                @endif
                                <th class="pr-4">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($projects)>0)
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>
                                            <input class="" type="checkbox" value="{{$project->project_id}}" name="project_id[]" id="project_id">
                                            {{$project->project_id}}
                                        </td>
                                        <td><h5><a href="{{route('project-details')}}?id={{$project->project_id}}">{{ $project->title}}</a></h5></td>
                                        <td>{{ Str::limit($project->description,100) }}</td>
                                        <td><span class=" badge badge-pill badge-info">{{$project->status}}</span></td>
                                        @if (Auth::user()->type == 3)
                                        <td>
                                            <form class="form-horizontal" method="POST"
                                                  action="{{ route('project-publish') }}">
                                                {{ csrf_field() }}
                                                <input id="id" type="hidden" class="form-control" name="id"
                                                       value="{{ $project->project_id }}" required>
                                                @if ( $project->isactive ==1)
                                                    <input id="status" type="hidden" class="form-control" name="status"
                                                           value="0" required>

                                                    <button type="submit" class=" badge badge-pill badge-inverse-success" {{( $project->status == 1) || (Auth::user()->type==2) ? "disabled":""}} >
                                                        <i class="mdi mdi-account-check"></i> {{ __('Published') }}
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
                                        @elseif (Auth::user()->type == 2)
                                        <td><span class=" badge badge-pill badge-info">{{$project->created_by ?? ''}}</span></td>
                                        <td>{{$project->created_at ?? ''}}</td>
                                        <td><span class=" badge badge-pill badge-info">{{$project->assigned_name ?? ''}}</span></td>
                                        @elseif (Auth::user()->type == 4)
                                            <td><span class=" badge badge-pill badge-info">{{$project->assigned_by_name ?? ''}}</span></td>
                                            <td>{{$project->assigned_at ?? ''}}</td>
                                        @endif
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
                                                       href="@if((Auth::user()->type==3)&&($project->status==1))#@else{{route('project-edit')}}?id={{$project->project_id}}@endif"><i
                                                            class="mdi mdi-account-edit"></i> Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#"><i class="mdi mdi-delete"></i>
                                                        Delete</a>
                                                    @if (Auth::user()->type == 2)
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" href="" data-project-id="{{$project->project_id}}" onclick="get_project_id(this)"><i class="mdi mdi-delete"></i>
                                                        Assigned to</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9">
                                        No project found
                                    </td>
                                </tr>

                            @endif
                            </tbody>
                        </table>
                    </div>

{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
        {!! $projects->withQueryString()->links('pagination::bootstrap-5') !!}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>--}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assigned an employee </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{route('project-assigned-to')}}">
                    @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="assigned_to" class="form-label font-weight-bold" >Assigned To</label>
                            {{--                                        <input type="text" class="form-control" value="{{$projects->assigned_to ?? ''}}">--}}
                            <input type="hidden" name="ass_project_id" id="ass_project_id" value=""/>
                            <select class="js-example-basic-single select2-hidden-accessible @error('assigned_to') is-invalid @enderror" id="assigned_to" name="assigned_to" required
                                    style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" >
                                <option value="">...</option>
                                @if(!empty($assigned_users))
                                    @foreach($assigned_users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                @else
                                    <option value=""> No user found </option>
                                @endif
                            </select>

                            @error('isactive')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="save" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function get_project_id(c){
            var project_id = c.getAttribute('data-project-id');
            //alert(project_id);
            document.getElementById("ass_project_id").value = project_id;

        }

    </script>

@endsection
