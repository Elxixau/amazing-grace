@extends('layouts.admin')

@section('title', 'Page Setting')

@php
  $breadcrumbItems = [
    ['label' => 'Log Activity', 'url' => route('admin.log.index')],
  ];
@endphp

@section('content')
@include('includes.notification')
    <div class="card shadow card-default p-4">
        <h3 class="mb-4">Log Aktivitas</h3>
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label>User</label>
                    <select name="user_id" class="form-control">
                        <option value="">-- Semua User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Method</label>
                    <select name="method" class="form-control">
                        <option value="">-- Semua Method --</option>
                        @foreach([ 'POST', 'PUT', 'PATCH', 'DELETE'] as $method)
                            <option value="{{ $method }}" {{ request('method') == $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Reset</a>                    
                </div>
            </div>
        </form>

        <form id="deleteAllForm" action="{{ route('admin.log.clear') }}" method="POST" >
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger mb-3" onclick="confirmDeleteAll()">
                <i class="mdi mdi-delete"></i> Hapus Semua Log
            </button>
        </form>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tabs">
                @forelse($logs as $log)
                    <div class="media media-md {{ $loop->odd ? 'bg-light' : 'bg-warning-10' }} p-4 mb-0">
                        <div class="media-sm-wrapper" style="width: 40px; height: 40px; overflow: hidden; border-radius: 50%;">
                            @if($log->user?->profile_img)
                                <img src="{{ asset('storage/' . $log->user->profile_img) }}" alt="User Image" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/user/default.png') }}" alt="User Image" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="media-body ms-3">
                            <span class="title mb-0 fw-bold">{{ $log->user->name ?? 'Guest' }}</span>
                            <div class="discribe">
                                Menjalankan <code>{{ $log->route ?? $log->uri }} </code>
                                metode <strong>{{ $log->method }}</strong>
                            </div>
                            <span class="time text-muted small">
                                <time>{{ \Carbon\Carbon::parse($log->logged_at)->diffForHumans() }}</time>
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-muted text-center">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $logs->links('pagination::bootstrap-4') }}
        </div>                
    </div>

<script>
    function confirmDeleteAll() {
        Swal.fire({
            title: 'Hapus Semua Log Activity?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteAllForm').submit();
            }
        });
    }
</script>

@endsection

