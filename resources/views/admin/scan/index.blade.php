@extends('layouts.admin')

@section('title', 'Scan Page')

@php
  $breadcrumbItems = [
    ['label' => 'Ticket', 'url' => route('admin.ticket.index')],
    ['label' => 'Scan']
  ];
@endphp
@section('content')
<script src="https://unpkg.com/html5-qrcode"></script>
   <div class="card shadow-lg mx-auto mb-5" style="max-width: 768px;">
                <div class="card-body">

                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h2 class="card-title h4 fw-bold text-dark">📷 Scan QR Code</h2>
                        <p class="text-muted small mt-2">Pilih kamera & arahkan ke QR untuk melanjutkan</p>
                    </div>

                    <!-- Pilih Kamera -->
                    <div class="mb-4">
                        <label for="cameraSelect" class="form-label">Pilih Kamera:</label>
                        <select id="cameraSelect" class="form-select">
                            <option value="">Memuat kamera...</option>
                        </select>
                    </div>

                    <!-- QR Reader -->
                    <div id="reader" class="border rounded mb-4" style="width: 100%; min-height: 200px;"></div>

                    <!-- Langkah-langkah -->
                    <div class="text-muted small">
                        <ul class="ps-3">
                            <li>Arahkan kamera ke QR Code dengan jelas</li>
                            <li>QR hanya dapat digunakan satu kali</li>
                            <li>Sistem akan redirect otomatis setelah scan</li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="d-flex justify-content-between p-4">
                    <h3>Scanned Ticket</h3>
                    <a href="{{ route('admin.ticket.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Ticket ID</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Seat Count</th>
                                <th scope="col">Seat Group</th>
                                <th scope="col">Scanned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = ($scannedTickets->currentPage() - 1) * $scannedTickets->perPage() + 1; @endphp

                            @forelse($scannedTickets as $qr)
                                <tr>
                                    <td>{{ $counter++ }}.</td>
                                    <td>{{ $qr->id }}</td>
                                    <td>{{ $qr->ticket->name }}</td>
                                    <td>{{ $qr->ticket->email }}</td>
                                    <td>{{ $qr->ticket->seat_count }}</td>
                                    <td>{{ $qr->ticket->seat_group }}</td>
                                    <td>{{ \Carbon\Carbon::parse($qr->scanned_at)->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada scan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <div class="mt-4">
                            {{ $scannedTickets->links() }}
                        </div>
                    </table>
                </div>
            </div>
        
        <!-- SweetAlert & Html5Qrcode -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/html5-qrcode@2.3.9/html5-qrcode.min.js"></script>

<script>
    let html5QrCode = null;
    let currentCameraId = null;
    let isProcessing = false;

    function startScanner(cameraId) {
        console.log("🔍 Memulai kamera:", cameraId);

        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
                html5QrCode.start(
                    { deviceId: { exact: cameraId } },
                    { fps: 10, qrbox: 100},
                    onScanSuccess,
                    onScanFailure
                ).then(() => {
                    console.log("✅ Kamera dimulai ulang");
                }).catch(err => {
                    console.error("❌ Gagal mulai ulang:", err);
                });
            });
        } else {
            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { deviceId: { exact: cameraId } },
                { fps: 10, qrbox: 250 },
                onScanSuccess,
                onScanFailure
            ).then(() => {
                console.log("✅ Kamera dimulai");
            }).catch(err => {
                console.error("❌ Gagal mulai kamera:", err);
            });
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        if (isProcessing) return;
        isProcessing = true;

        console.log("✅ QR terbaca:", decodedText);

        let ticketId;
        try {
            const urlParams = new URL(decodedText).searchParams;
            ticketId = urlParams.get('ticket_id');
            if (!ticketId) {
                throw new Error("ticket_id tidak ditemukan");
            }
        } catch (e) {
            console.error("❌ Format QR tidak valid:", e);
            Swal.fire('QR tidak valid', 'Format QR tidak dikenali.', 'error');
            resetProcessing();
            return;
        }

        Swal.fire({
            title: 'Memproses QR...',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading()
        });

        fetch(`/admin/tickets/mark-scanned/${ticketId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        })
        .then(async response => {
    if (response.ok) {
        Swal.fire({
            title: '✅ QR Valid!',
            text: 'Mengalihkan ke halaman...',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = decodedText;
        });
    } else {
        const errorData = await response.json();
        Swal.fire('QR tidak valid', errorData.message, 'error');
        resetProcessing();
    }
})

        .catch(error => {
            console.error("❌ Fetch error:", error);
            Swal.fire('Terjadi Kesalahan', 'Tidak bisa memvalidasi QR. Coba lagi.', 'error');
            resetProcessing();
        });
    }

    function onScanFailure(error) {
        // Bisa aktifkan log jika perlu
        // console.warn("Gagal scan:", error);
    }

    function resetProcessing() {
        setTimeout(() => {
            isProcessing = false;
        }, 3000);
    }

    // Inisialisasi kamera setelah halaman siap
    document.addEventListener("DOMContentLoaded", function () {
        Html5Qrcode.getCameras().then(devices => {
            const select = document.getElementById('cameraSelect');
            select.innerHTML = '';

            if (devices.length === 0) {
                select.innerHTML = '<option>Tidak ada kamera ditemukan</option>';
                return;
            }

            devices.forEach(device => {
                const option = document.createElement('option');
                option.value = device.id;
                option.text = device.label || `Kamera ${device.id}`;
                select.appendChild(option);
            });

            currentCameraId = devices[0].id;
            select.value = currentCameraId;
            startScanner(currentCameraId);
        });

        document.getElementById('cameraSelect').addEventListener('change', function () {
            currentCameraId = this.value;
            if (currentCameraId) {
                startScanner(currentCameraId);
            }
        });
    });
</script>



@endsection