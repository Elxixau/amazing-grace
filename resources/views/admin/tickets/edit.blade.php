@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@php
  $breadcrumbItems = [
    ['label' => 'Ticket', 'url' => route('admin.ticket.index')],
    ['label' => 'Edit']
  ];
@endphp

@section('content')
  @include('includes.notification')    
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body d-flex flex-wrap align-items-center">
                        <div class="col-md-8">
                            <h4 class="card-title mb-3">🎟️ {{ $ticket->ticket_id }}</h4>
                            
                            <p class="mb-2"><strong>Order By:</strong> {{ $ticket->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $ticket->email }}</p>
                            <p class="mb-2"><strong>Jumlah Seat:</strong> {{ $ticket->seat_count }}</p>
                            <p class="mb-2"><strong>Group Seat:</strong> {{ $ticket->seat_group }}</p>

                            
                            <p class="mb-2"><strong>Scanned by:</strong> 
                                @if($ticket->qrAccess->scanned_by == 'UNKNOWN')
                                    <span class="text-black">----|----</span>

                                @elseif($ticket->qrAccess->scanned_by != 'UNKNOWN')
                                    <span class="text-black">{{$ticket->qrAccess->user->name}}</span>

                                @else
                                    <span class="text-muted p-2 rounded bg-light">Tidak Diketahui</span>
                                @endif
                            </p>

                            @if($ticket->qrAccess)
                                <p class="mb-2"><strong>Status :</strong> 
                                    <span class="badge text-white {{ $ticket->qrAccess->is_scanned ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $ticket->qrAccess->is_scanned ? 'SCANNED' : 'UNSCANNED' }}
                                    </span>
                                </p>

                                @if($ticket->qrAccess->scanned_at)
                                    <p class="mb-2"><strong>Waktu Scan:</strong> 
                                        {{ \Carbon\Carbon::parse($ticket->qrAccess->scanned_at)->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            @else
                                <p class="text-danger mt-2">QR belum tersedia untuk tiket ini.</p>
                            @endif
                        </div>

                        @if($ticket->qrAccess)
                        <div class="col-md-4 text-center">
                            <div class="border rounded-3 p-3 bg-light">
                                <img src="{{ $ticket->qrAccess->qr_path }}" alt="QR Code" class="img-fluid mb-2" style="max-width: 200px;">
                                <p class="small text-muted"> {{$ticket->qrAccess->id}}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
@endsection