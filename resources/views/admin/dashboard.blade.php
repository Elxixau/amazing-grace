@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <!-- Chart: Distribusi Tiket -->
    <div class="col-12 col-xl-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Distribusi Tiket</h5>
                <small class="text-muted">Visualisasi status tiket</small>
            </div>
            <div class="card-body">
                <canvas id="ticketChart" style="max-height: 500px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card card-default h-100">
            <div class="card-header">
                <h5 class="mb-0">Admin Scan</h5>
                <small class="text-muted">Total Admin Aktif: {{ $totalScanningAdmins }}</small>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($scanningAdmins as $admin)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $admin->name }}
                            <span class="badge badge-primary badge-pill">{{ $admin->total_scans }} Scan</span>
                        </li>
                    @empty
                        <li class="list-group-item">Belum ada admin melakukan scan</li>
                    @endforelse
                </ul>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="text-center text-uppercase">
                    Total tiket yang belum scan: <strong>{{ $totalTicketsScanned }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Tiket -->
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Total Tiket Terdaftar</h5>
                <h2>{{ $totalTickets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <h5 class="card-title">Tiket Telah Digunakan</h5>
                <h2>{{ $usedTickets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card bg-warning text-dark h-100">
            <div class="card-body">
                <h5 class="card-title">Tiket Telah Dipesan</h5>
                <h2>{{ $reservedTickets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card border-info h-100">
            <div class="card-body">
                <h5 class="card-title text-info">Scan oleh Anda</h5>
                <h2>{{ $myScannedCount }}</h2>
                <p class="text-muted mb-0">Jumlah tiket yang Anda scan secara pribadi</p>
            </div>
        </div>
    </div>
</div>

<!-- Info Publik & Admin Scan -->
<div class="row">
    @if($post)
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            @if($post->banner_image)
                <img src="{{ asset('storage/' . $post->banner_image) }}" class="card-img-top" alt="Banner">
            @endif
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">{{ $post->title }}</h5>
                    <span class="badge badge-pill {{ $post->show ? 'badge-success' : 'badge-secondary' }}">
                        {{ $post->show ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <p class="card-text mt-2">{{ $post->excerpt }}</p>
                <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">Edit Info</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('ticketChart').getContext('2d');
    const ticketChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Digunakan', 'Telah Dipesan', 'Sisa Kuota'],
            datasets: [{
                label: 'Jumlah Tiket',
                data: [
                    {{ $usedTickets }},
                    {{ $reservedTickets }},
                    {{ $remainingQuota }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',  // success
                    'rgba(255, 193, 7, 0.8)',  // warning
                    'rgba(220, 53, 69, 0.8)'   // danger
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
