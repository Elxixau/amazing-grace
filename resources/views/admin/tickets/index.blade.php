@extends('layouts.admin')

@section('title', 'Ticket Table')
@php
  $breadcrumbItems = [
    ['label' => 'Ticket', 'url' => route('admin.ticket.index')],
  ];
@endphp
@section('content')
<div class="card bg-dark bg-gradient card-default text-white ">
       <div class="px-6 py-4 d-flex justify-content-between align-items-center ">
          <p><span class="text-secondary text-capitalize"> ------- </span> </p>
          
            <p> <span class="text-secondary text-capitalize"> ------- </span> </p>
        </div>
        <div class="px-6 py-4 d-flex justify-content-center align-items-center ">
          
          <a class="bg-light p-2 rounded border" href="{{route('admin.ticket.scan')}}">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
            <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z"/>
            <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z"/>
            <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z"/>
            <path d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z"/>
            <path d="M12 9h2V8h-2z"/>
          </svg>
          Scan Ticket
          </a>
            
        </div>
        <div class="px-6 py-4 d-flex justify-content-between align-items-center ">
          <p><span class="text-secondary text-capitalize"> ------- </span> </p>
          
            <p> <span class="text-secondary text-capitalize"> ------- </span> </p>
        </div>

        
      </div>

      <div class="row">
        <div class="col-xl-12">
          <!-- Basic Table-->
          <div class="card shadow card-default">
            <div class="card-header d-flex justify-content-between align-items-center ">
              <h2>Ticket Table</h2>

              <div class="py-2">
                <!-- Filter Form -->
                <form action="{{ route('admin.ticket.index') }}" method="GET" class="d-inline-flex align-items-center me-2">
                  <input type="text" name="search" placeholder="Cari Nama/Email" class="form-control form-control-sm me-2" value="{{ request('search') }}">
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        @foreach(['SCANNED', 'UNSCANNED'] as $div)
                            <a class="dropdown-item {{ request('divisi') === $div ? 'active' : '' }}" 
                              href="{{ request()->fullUrlWithQuery(['status' => $div]) }}">
                                {{ ucfirst($div) }}
                            </a>
                        @endforeach
                    </div>
                  
                  <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                </form>

                <!-- Export Button -->
                <a href="" class="btn btn-info btn-sm">
                  Export Excel
                </a>
              </div>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalForm">
                Tambah Ticket
              </button>
            
          <!-- Form Modal -->
          <div class="modal fade" id="exampleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalFormTitle">Tambah Ticket</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.ticket.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                                <div class="form-group">
                                    <label for="nama">Nama Lengkap:</label>
                                    <input type="text" class="form-control border-bottom" id="name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control border-bottom" id="email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label>Jumlah Kursi:</label>
                                    <div class="seat-radio-buttons">
                                        @foreach($seatOptions as $seatOption)
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input seat-radio" id="seat_{{ $seatOption }}" name="seat_count" value="{{ $seatOption }}">
                                                <label class="form-check-label seat-label" for="seat_{{ $seatOption }}">{{ $seatOption }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Pilih Group Kursi:</label>
                                    <div class="seat-radio-buttons">
                                        <div class="row">
                                            @foreach($seatGroup as $group)
                                                <div class="col-md-6 col-lg-6 mb-4 d-flex align-items-stretch">
                                                    <div class="card text-center w-100">
                                                        <div class="card-header">Group</div>
                                                        <div class="card-body">
                                                            <label class="form-check-label seat-label" for="seat_{{ $group->group_code }}">
                                                                {{ $group->group_name }}
                                                            </label>
                                                            <p class="card-text">Sisa Kuota: <strong>{{ $group->quota }}</strong></p>
                                                            <input type="radio"
                                                                class="form-check-input seat-radio mt-2"
                                                                id="seat_{{ $group->group_code }}"
                                                                name="seat_group"
                                                                value="{{ $group->group_code }}">
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            {{ optional($group->updated_at)->translatedFormat('d F Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
               
              </div>
            </div>
          </div>

            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Id Ticket</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Seat</th>
                        <th scope="col">Group</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Booking</th>           
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    @php $counter = ($ticket->currentPage() - 1) * $ticket->perPage() + 1; @endphp

                    <tbody>
                    @foreach ($ticket as $t)
                    <tr>
                        <td>{{ $counter }}.</td>
                        <td>{{ $t->ticket_id }}</td>
                        <td>{{ $t->name }}</td>
                        <td>{{ $t->seat_count }}</td>
                        <td>{{ $t->seat_group }}</td>
                       <td>
                          @if($t->qrAccess?->is_scanned === 0)
                              <span class="text-white bg-danger p-2 rounded">unscanned</span>
                          @elseif($t->qrAccess?->is_scanned === 1)
                              <span class="text-white bg-success p-2 rounded">scanned</span>
                          @else
                              <span class="text-muted">Belum ada data</span>
                          @endif
                      </td>

                        <td>{{ $t->created_at }}</td>
                        <td class="text-center d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.ticket.edit', $t->ticket_id) }}" >
                            <i class="mdi mdi-open-in-new"></i>
                        </a>
                        <form id="deleteForm{{ $t->id }}" action="{{ route('admin.ticket.delete', $t->ticket_id) }}" method="POST" id="deleteForm{{ $t->ticket_id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button"  onclick="confirmDelete({{ $t->id }})"  >
                            <i class="mdi mdi-close text-danger   "></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    @php $counter++; @endphp
                    @endforeach
                    </tbody>
                    @include('includes.notification')
                    <p class="text-muted mt-2 mb-0">
                        Menampilkan <strong>{{ $ticket->count() }}</strong> dari total <strong>{{ $totalTicket }}</strong> ticket{{ $ticket->count() === 1 ? '' : 's' }}.
                    </p>
                </table>
                <div class="mt-4">
                  {{ $ticket->links() }}
                </div>
                <script>
                function confirmDelete(id) {
                  Swal.fire({
                    title: 'Hapus Ticket',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      document.getElementById('deleteForm' + id).submit();
                    }
                  });
                }
              </script>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection