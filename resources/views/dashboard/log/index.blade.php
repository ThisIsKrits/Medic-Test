@extends('layouts.dashboard')
@push('title')
    {{ $title.' | '.config('app.name', 'Medic-Web') }}
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Model</th>
                            <th>Event</th>
                            <th>User</th>
                            <th>Waktu</th>
                            <th>Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $audit)
                            <tr>
                                <td>{{ class_basename($audit->auditable_type) }} #{{ $audit->auditable_id }}</td>
                                <td><span class="badge badge-info text-uppercase">{{ $audit->event }}</span></td>
                                <td>{{ $audit->user->name ?? 'System' }}</td>
                                <td>{{ $audit->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#audit-{{ $audit->id }}">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse" id="audit-{{ $audit->id }}">
                                <td colspan="5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><strong>Old Values</strong></h6>
                                            <ul class="list-group list-group-flush">
                                                @forelse ($audit->old_values as $key => $value)
                                                    <li class="list-group-item">
                                                        <strong>{{ $key }}:</strong> {{ $value }}
                                                    </li>
                                                @empty
                                                    <li class="list-group-item text-muted">Tidak ada</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><strong>New Values</strong></h6>
                                            <ul class="list-group list-group-flush">
                                                @forelse ($audit->new_values as $key => $value)
                                                    <li class="list-group-item">
                                                        <strong>{{ $key }}:</strong> {{ $value }}
                                                    </li>
                                                @empty
                                                    <li class="list-group-item text-muted">Tidak ada</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger">Tidak ada data audit tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
