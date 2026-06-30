@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Add Services</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Services</a></li>
                            <li class="breadcrumb-item active">Add Service</li>
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

                        <h4 class="card-title">Add Service</h4>
                        <p class="card-title-desc"></p>
                        <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                            @csrf
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="title" placeholder="Service Title" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Short Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" type="text" name="short_desc" placeholder="Service Short Description" id="example-text-input"></textarea>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Long Description</label>
                                <div class="col-sm-10">
                                    <textarea id="elm1" type="text" name="long_desc" placeholder="Service Long Description" ></textarea>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Image</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" name="image" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Multiple Images</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" name="icon[]" id="example-text-input" multiple>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Meta Title <small class="text-muted">(max 100 chars)</small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="meta_title" maxlength="100" placeholder="SEO page title (defaults to service title if blank)">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Meta Description <small class="text-muted">(max 300 chars)</small></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="meta_description" maxlength="300" rows="3" placeholder="SEO description shown in search results"></textarea>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input class="btn btn-primary" type="submit" value="Add Service">
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
