@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Update Why Choose Us</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Why Choose</a></li>
                            <li class="breadcrumb-item active">Update Why Choose Us</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Update Why Choose Us</h4>
                        <p class="card-title-desc"></p>
                        <form method="POST" action="{{ route('why-us.update', $data->id) }}" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Why Choose Us Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="title" value="{{ $data->title }}" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Why Choose Us Subtitle</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="subtitle" value="{{ $data->subtitle }}" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Why Choose Us Description</label>
                                <div class="col-sm-10">
                                    <textarea id="elm1" type="text" name="desc" placeholder="Why Choose Us Description" >
                                        {{ $data->desc }}
                                    </textarea>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Photo</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" name="image" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src="{{ asset($data->image) }}" height="100" alt="">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input class="btn btn-primary" type="submit" value="Update Why Choose Us">
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
@endsection
