@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">All Services</h4>
                        <p class="card-title-desc">
                        </p>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Project Category</th>
                                <th>Project Title</th>
                                <th>Project Description</th>
                                <th>Project Client</th>
                                <th>Project Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->project_category->name }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ str()->limit($item->short_desc, 30) }}</td>
                                    <td>
                                        {{ $item->client }}
                                    </td>
                                    <td>
                                        <img src="{{ asset($item->image) }}" height="50">
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('projects.destroy', $item->id) }}">
                                            @method('DELETE') @csrf
                                            <a href="{{ route('projects.edit', $item->id) }}" class="btn btn-primary">Edit</a>
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
    </div>
@endsection
