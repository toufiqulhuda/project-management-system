@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Project Details</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('project')}}">Project</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Project details</li>
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
                            <h4 class="card-title">Project detials</h4>
                            <p class="card-description">project details from </p>
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
                    {{dd($attached_files)}}
                    <form class="forms-sample" method="POST" action="{{ route('project-add') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <label for="title">Title <i class="mdi mdi-multiplication"></i></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required
                                           placeholder="Title">
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
                                              placeholder="Description"></textarea>
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
                                        <option value="0">Draft</option>
                                        <option value="1">Published</option>
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
                                    <label for="attachment" class="form-label">Attachment <span class="mdi mdi-paperclip"></span></label>
                                    <input class="form-control @error('attachment') is-invalid @enderror" type="file" id="attachment" name="attachment[]" multiple>
                                    @error('attachment')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
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
