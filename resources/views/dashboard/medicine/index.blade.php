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
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Harga</th>
                            <th>Periode Berlaku</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $medicine)
                            @php $rowspan = max(count($medicine['prices']), 1); @endphp
                            <tr>
                                <td rowspan="{{ $rowspan }}">{{ $medicine['name'] }}</td>

                                @if (!empty($medicine['prices']))
                                    @php $first = array_shift($medicine['prices']); @endphp
                                    <td>Rp {{ number_format($first['unit_price']) }}</td>
                                    <td>{{ $first['start_date']['formatted'] }} - {{ $first['end_date']['formatted'] ?? 'Sekarang' }}</td>
                                @else
                                    <td colspan="2" class="text-muted">Tidak ada harga tersedia</td>
                                @endif
                            </tr>

                            @foreach ($medicine['prices'] as $price)
                                <tr>
                                    <td>Rp {{ number_format($price['unit_price']) }}</td>
                                    <td>{{ $price['start_date']['formatted'] }} - {{ $price['end_date']['formatted'] ?? 'Sekarang' }}</td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-danger">Data tidak tersedia.</td>
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
