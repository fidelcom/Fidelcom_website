@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Update Contact Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contact Details</a></li>
                            <li class="breadcrumb-item active">Update Contact Details</li>
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

                        <h4 class="card-title">Update Contact Details</h4>
                        <p class="card-title-desc"></p>
                        <form method="POST" action="{{ route('contact.update', $data->id) }}" enctype="multipart/form-data">
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="address" value="{{ $data->address }}" placeholder="Address" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Phone No</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="phone" value="{{ $data->phone }}" placeholder="Phone No" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="email" name="email" value="{{ $data->email }}" placeholder="Email" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Instagram Link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="instagram" value="{{ $data->instagram }}" placeholder="Instagram Link" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Twitter Link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="twitter" value="{{ $data->twitter }}" placeholder="Twitter Link" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Linkedin Link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="linkedin" value="{{ $data->linkedin }}" placeholder="Linkedin Link" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Facebook Link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="facebook" value="{{ $data->facebook }}" placeholder="Facebook Link" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Youtube Link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="youtube" value="{{ $data->youtube }}" placeholder="Youtube Link" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Google Plus Link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="google" value="{{ $data->google }}" placeholder="google Link" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Office Pinterest Link</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="pinterest" value="{{ $data->pinterest }}" placeholder="Pinterest Link" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input class="btn btn-primary" type="submit" value="Update Contact Details">
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
