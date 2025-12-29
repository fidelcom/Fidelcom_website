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
                                <th>Service Title</th>
                                <th>Service Description</th>
                                <th>Service Image</th>
{{--                                <th>Slider Icon</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ str()->limit($item->short_desc, 30) }}</td>
                                    <td>
                                        <img src="{{ asset($item->image) }}" height="50" alt="">
                                    </td>
{{--                                    <td>--}}
{{--                                        <img src="{{ asset($item->icon) }}" height="50" alt="">--}}
{{--                                    </td>--}}
                                    <td>
                                        <form method="POST" action="{{ route('services.destroy', $item->id) }}">
                                            @method('DELETE') @csrf
                                            <a href="{{ route('services.edit', $item->id) }}" class="btn btn-primary">Edit</a>
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
