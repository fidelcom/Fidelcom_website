@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Update Services</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Services</a></li>
                            <li class="breadcrumb-item active">Update Service</li>
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

                        <h4 class="card-title">Update Service</h4>
                        <p class="card-title-desc"></p>
                        <form method="POST" action="{{ route('services.update', $data->id) }}" enctype="multipart/form-data">
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="title" value="{{ $data->title }}" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Short Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" type="text" name="short_desc" placeholder="Service Short Description" id="example-text-input">
                                        {{ $data->short_desc }}
                                    </textarea>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Long Description</label>
                                <div class="col-sm-10">
                                    <textarea id="elm1" type="text" name="long_desc" placeholder="Service Long Description" >
                                        {{ $data->long_desc }}
                                    </textarea>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src="{{ asset($data->image) }}" height="50">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Service Icon</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" name="icon" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Meta Title <small class="text-muted">(max 100 chars)</small></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="meta_title" maxlength="100" value="{{ $data->meta_title }}" placeholder="SEO page title (defaults to service title if blank)">
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Meta Description <small class="text-muted">(max 300 chars)</small></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="meta_description" maxlength="300" rows="3" placeholder="SEO description shown in search results">{{ $data->meta_description }}</textarea>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input class="btn btn-primary" type="submit" value="Update Service">
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Multi Images</h4>
                        <p class="card-title-desc">
                        <form action="{{ route('multiple-image.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input class="form-control" type="hidden" name="service_id" value="{{ $data->id }}" id="example-text-input" >
                                            <input class="form-control" type="file" name="multiImage[]" id="example-text-input" multiple required>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </div>
                                <div class="col-md-2">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input class="btn btn-danger" type="submit" value="Add Multi Image">
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                        </form>
                        </p>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Service Multi-Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($data->multiImage as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <img src="{{ asset($item->image) }}" height="50">
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('multiple-image.destroy', $item->id) }}">
                                            @method('DELETE') @csrf
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
@endsection
