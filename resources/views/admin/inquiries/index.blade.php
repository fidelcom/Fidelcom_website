@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">All Inquiries</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Inquiries</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">All Inquiries (Contact Us + Let's Talk)</h4>
                            <a href="{{ route('admin.inquiries.export') }}" class="btn btn-success btn-sm">
                                <i class="mdi mdi-download me-1"></i> Export CSV
                            </a>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Source</th>
                                    <th>Name</th>
                                    <th>Email / Phone</th>
                                    <th>Subject / Service</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Received</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inquiries as $key => $item)
                                    <tr class="{{ $item['status'] == 0 ? 'table-warning' : '' }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($item['source'] === 'contact_us')
                                                <span class="badge bg-primary">Contact Us</span>
                                            @else
                                                <span class="badge bg-info">Let's Talk</span>
                                            @endif
                                        </td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>
                                            {{ $item['email'] }}<br>
                                            <small class="text-muted">{{ $item['phone'] }}</small>
                                        </td>
                                        <td>
                                            @if($item['subject'])
                                                <strong>{{ $item['subject'] }}</strong>
                                            @elseif($item['service'])
                                                {{ $item['service'] }}
                                            @endif
                                        </td>
                                        <td>{{ Str::limit(strip_tags($item['message'] ?? ''), 60) }}</td>
                                        <td>
                                            <span class="badge {{ $item['status'] ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $item['status'] ? 'Read' : 'Unread' }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d M Y H:i') }}</td>
                                        <td>
                                            @if($item['source'] === 'contact_us')
                                                <a href="{{ route('contact.us.edit', $item['id']) }}" class="btn btn-primary btn-sm">
                                                    {{ $item['status'] == 0 ? 'Mark Read' : 'Mark Unread' }}
                                                </a>
                                                <form method="POST" action="{{ route('contact.us.destroy', $item['id']) }}" class="d-inline">
                                                    @method('DELETE') @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            @else
                                                <a href="{{ route('lets.talk.edit', $item['id']) }}" class="btn btn-primary btn-sm">
                                                    {{ $item['status'] == 0 ? 'Mark Read' : 'Mark Unread' }}
                                                </a>
                                                <form method="POST" action="{{ route('lets.talk.destroy', $item['id']) }}" class="d-inline">
                                                    @method('DELETE') @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
