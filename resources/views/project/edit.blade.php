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
                                    <label for="description">Description <i class="mdi mdi-multiplication"></i></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="10" id="description" name="description" required
                                              placeholder="Description">{{$projects->description}}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="isactive">Status <i class="mdi mdi-multiplication"></i></label>
                                    <select class="js-example-basic-single select2-hidden-accessible @error('isactive') is-invalid @enderror" required id="isactive" name="isactive"
                                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                        <option value="">...</option>
                                        <option value="0" {{$projects->isactive == 0 ? "selected":""}}>Draft</option>
                                        <option value="1" {{$projects->isactive == 1 ? "selected":""}}>Published</option>
                                    </select>
                                    @error('isactive')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

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
                                                <td><a href="{{$attached_file->file_path}}"> <button type="button" class="btn btn-primary btn-sm rounded-pill"><i class="mdi mdi-download"></i> </button></a></td>
                                                <td>
                                                    <a href="javascript:void(0)" data-url="{{ route('attachment.delete', $attached_file->id) }}"
                                                       class="btn btn-danger btn-sm rounded-pill delete-attachment"><i class="mdi mdi-delete"></i></a>
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
                                    <input class="form-control @error('attachment') is-invalid @enderror" type="file" id="attachment" name="attachment[]" multiple>
                                    @error('attachment')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
                            //alert(data.success);
                            trObj.parents("tr").remove();
                        }
                    });
                }

            });

        });

    </script>

@endsection
