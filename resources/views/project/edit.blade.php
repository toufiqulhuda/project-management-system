@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Edit Project</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('project')}}">Project</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Edit Project</li>
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
                <ol>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
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
                            <h4 class="card-title">Edit Project</h4>
                            <p class="card-description">Edit project from </p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 text-sm-right text-md-right text-lg-right">
                            <a href="{{route('project')}}">
                                <button type="button"
                                        class="btn btn-icon-text mb-3 ml-4 mb-sm-0 btn-inverse-primary font-weight-normal">
                                    <span class="mdi mdi-arrow-right-circle-outline btn-icon-prepend"></span>Goto Project list
                                </button>
                            </a>
                        </div>
                    </div>
                    @if(!empty($projects))

                    <form class="forms-sample" method="POST" action="{{ route('project-update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="title">Title <i class="mdi mdi-multiplication"></i></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required
                                           {{(Auth::user()->type == 2 or Auth::user()->type == 4 ) ? "readonly disabled" : ""}}
                                           placeholder="Title" value="{{$projects->title}}">
                                    @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="description">Instructions <i class="mdi mdi-multiplication"></i></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="10" id="description" name="description" required
                                              {{(Auth::user()->type == 2 or Auth::user()->type == 4 ) ? "readonly disabled" : ""}}
                                              placeholder="Description">{{$projects->description}}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->type == 3) {{-- client --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="isactive">Status <i class="mdi mdi-multiplication"></i></label>
                                    <select class="js-example-basic-single select2-hidden-accessible @error('isactive') is-invalid @enderror" required id="isactive" name="isactive"
                                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" >
                                        <option value="">...</option>
                                        <option value="0" {{($projects->isactive == 0) ? "selected":""}}{{($projects->status == 1) ? "disabled":""}}>Draft</option>
                                        <option value="1" {{($projects->isactive == 1) ? "selected":""}}>Published</option>
                                    </select>
                                    @error('isactive')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="attachment" class="form-label">Attached files<span class="mdi mdi-paperclip"></span></label>
                                    <div class="table-responsive">
                                    <table class="table table-sm border align-middle">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">File Name</th>
                                            <th scope="col">Uploaded By</th>
                                            <th scope="col">Download</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($attached_files)>0)
                                        @foreach ($attached_files as $attached_file)
                                            <tr>
                                                <th scope="row">{{$loop->index+1}}</th>
                                                <td><strong>{{$attached_file->file_name}}</strong></td>
                                                <td><span class=" badge badge-pill badge-warning">{{$attached_file->role_name}}</span></td>
                                                <td><a href="{{$attached_file->file_path}}"> <button type="button" class="btn btn-primary btn-sm rounded-pill"><i class="mdi mdi-download"></i> </button></a></td>
                                                <td>
                                                    @if($attached_file->created_by == Auth::user()->id)
                                                    <a href="javascript:void(0)" data-url="{{ route('attachment.delete', $attached_file->id) }}"
                                                       class="btn btn-danger btn-sm rounded-pill delete-attachment"><i class="mdi mdi-delete"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    No attachment found
                                                </td>
                                            </tr>

                                        @endif
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="attachment" class="form-label">Attachment <span class="mdi mdi-paperclip"></span></label>
                                    <div class="input-group">
                                        <input class="form-control file-upload-info @error('attachment') is-invalid @enderror" type="file" id="attachment" name="attachment[]" multiple>
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button"> <i class="mdi mdi-upload btn-icon-prepend"></i> Upload </button>
                                        </span>
                                    </div>

                                    @error('attachment')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->type == 2 ) {{-- Admin --}}
                            <div class="row">
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label for="duration" class="form-label font-weight-bold" >Duration</label>
                                        <input type="text" class="form-control" name="duration" value="{{$projects->duration ?? ''}}" >
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label for="cost" class="form-label font-weight-bold" >Cost in BDT</label>
{{--                                        <input type="text" class="form-control" value="{{$projects->cost ?? ''}}" >--}}
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">$</span>
                                            </div>
                                            <input type="text" class="form-control text-right" aria-label="Amount (to the nearest dollar)" name="cost" value="{{$projects->cost ?? ''}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label for="assigned_to" class="form-label font-weight-bold" >Assigned To</label>
{{--                                        <input type="text" class="form-control" value="{{$projects->assigned_to ?? ''}}">--}}
                                        <select class="js-example-basic-single select2-hidden-accessible @error('assigned_to') is-invalid @enderror" id="assigned_to" name="assigned_to"
                                                style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" >
                                            <option value="">...</option>
                                            @if(!empty($assigned_users))
                                                @foreach($assigned_users as $user)
                                                    <option value="{{$user->id}}" {{($user->id==$projects->assigned_to)? 'selected' : ''}}>{{$user->name}}</option>
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
                        @endif
                        @if(Auth::user()->type == 4 ) {{-- employee --}}
                            <div class="row">
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label for="start_at" class="form-label font-weight-bold" >Start At</label>
                                        <input type="date" class="form-control" name="start_at" value="{{$projects->start_at ?? ''}}" >
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label for="end_at" class="form-label font-weight-bold" >End At</label>
                                        <input type="date" class="form-control" name="end_at" value="{{$projects->end_at ?? ''}}" >
                                    </div>
                                </div>
                            </div>
                        @endif
                        <input type="hidden" name="id" value="{{$projects->project_id}}">
                        <button type="submit" class="btn btn-primary mr-2"><i class="mdi mdi-content-save"></i> Save
                        </button>
                        <button class="btn btn-secondary"><i class="mdi mdi-close-circle-outline"></i> Close</button>
                    </form>
                    @else
                        <div class="alert alert-info">
                            No record found
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /*------------------------------------------
            --------------------------------------------
            When click user on Show Button
            --------------------------------------------
            --------------------------------------------*/
            $(document).on('click', '.delete-attachment', function() {

                var attachmentURL = $(this).data('url');
                var trObj = $(this);

                if (confirm("Are you sure you want to delete this attachment?") == true) {
                    $.ajax({
                        url: attachmentURL,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(data) {
                            //alert(data.error); return;
                            if(data.error==undefined){
                                trObj.parents("tr").remove();
                            }else{
                                alert(data.error);
                            }

                        }
                    });
                }

            });

        });

    </script>

@endsection
