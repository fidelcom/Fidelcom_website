@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Update Gallery Images</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gallery</a></li>
                            <li class="breadcrumb-item active">Update Gallery</li>
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

                        <h4 class="card-title">Update Gallery</h4>
                        <p class="card-title-desc"></p>
                        <form method="POST" action="{{ route('gallery.update', $data->id) }}" enctype="multipart/form-data">
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
                                <label for="example-text-input" class="col-sm-2 col-form-label">Gallery Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="name" value="{{ $data->name }}" id="example-text-input">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <input class="btn btn-primary" type="submit" value="Update Gallery">
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

                        <h4 class="card-title">Gallery Images</h4>
                        <p class="card-title-desc">
                        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input class="form-control" type="hidden" name="name" value="{{ $data->name }}" id="example-text-input" >
                                            <input class="form-control" type="file" name="image[]" id="example-text-input" multiple required>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </div>
                                <div class="col-md-2">
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input class="btn btn-danger" type="submit" value="Add Gallery Image">
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
                                <th>Gallery Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach(\App\Models\Gallery::where('name', $data->name)->get() as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <img src="{{ asset($item->image) }}" height="50">
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('gallery.destroy', $item->id) }}">
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
