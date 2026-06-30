@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Get In Touch Messages</h4>
                        <p class="card-title-desc">
                        </p>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Phone No</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{!! str()->limit($item->name, 50) !!}</td>
                                    <td>{!! str()->limit($item->phone, 50) !!}</td>
                                    <td>{!! str()->limit($item->email, 50) !!}</td>
                                    <td>{!! $item->message !!}</td>
                                    <td>{!! $item->status == 0 ? 'Unread' : 'Read' !!}</td>
                                    <td>
                                        <form method="POST" action="{{ route('contact.destroy', $item->id) }}">
                                            @method('DELETE') @csrf
                                            <a href="{{ route('contact.us.edit', $item->id) }}" class="btn btn-primary">{{ $item->status == 0 ? 'Mark as Read' : 'Mark as Unread' }}</a>
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
