@extends('layouts.admin')

@section('admin')
    <div class="container-fluid">

        <!-- page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Fidelcom</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- stat cards -->
        <div class="row">
            <div class="col-xl-2 col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Blog Posts</p>
                                <h4 class="mb-0">{{ $stats['posts'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="mdi mdi-post-outline font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Projects</p>
                                <h4 class="mb-0">{{ $stats['projects'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-folder-multiple-outline font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Services</p>
                                <h4 class="mb-0">{{ $stats['services'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-info rounded-3">
                                    <i class="mdi mdi-cog-outline font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Team Members</p>
                                <h4 class="mb-0">{{ $stats['team'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-warning rounded-3">
                                    <i class="ri-team-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Testimonials</p>
                                <h4 class="mb-0">{{ $stats['testimonials'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-secondary rounded-3">
                                    <i class="mdi mdi-star-outline font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card {{ $stats['new_inquiries'] > 0 ? 'border border-warning' : '' }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">New Inquiries</p>
                                <h4 class="mb-0 {{ $stats['new_inquiries'] > 0 ? 'text-warning' : '' }}">
                                    {{ $stats['new_inquiries'] }}
                                </h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-danger rounded-3">
                                    <i class="ri-mail-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end stat cards -->

        <!-- recent inquiries -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Recent Inquiries</h4>
                            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Source</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject / Service</th>
                                        <th>Status</th>
                                        <th>Received</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentInquiries as $inquiry)
                                        <tr>
                                            <td>
                                                <span class="badge {{ $inquiry['source'] === 'Contact Us' ? 'bg-primary' : 'bg-info' }}">
                                                    {{ $inquiry['source'] }}
                                                </span>
                                            </td>
                                            <td>{{ $inquiry['name'] }}</td>
                                            <td>{{ $inquiry['email'] }}</td>
                                            <td>{{ Str::limit($inquiry['subject'] ?? '', 40) }}</td>
                                            <td>
                                                <span class="badge {{ $inquiry['status'] ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $inquiry['status'] ? 'Read' : 'Unread' }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($inquiry['created_at'])->format('d M Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No inquiries yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
