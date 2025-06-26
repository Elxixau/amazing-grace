@extends('layouts.admin')

@section('title', 'Users Tables')


@php
  $breadcrumbItems = [
    ['label' => 'Users', 'url' => route('admin.user.index')]
  ];
@endphp


@section('content')
<!-- Basic Table-->
          <div class="card shadow card-default">
            <div class="card-header d-flex justify-content-between align-items-center ">
              <h2>Users Table</h2>

              <div class="py-2">
                <!-- Filter Form -->
                <form action="{{ route('admin.user.index') }}" method="GET" class="d-inline-flex align-items-center me-2">
                  <input type="text" name="search" placeholder="Cari Nama/Email" class="form-control form-control-sm me-2" value="{{ request('search') }}">
                  <div class="dropdown mr-2">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                        Divisi
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        @foreach(['inti', 'acara', 'pubdok', 'perlengkapan', 'humas'] as $div)
                            <a class="dropdown-item {{ request('divisi') === $div ? 'active' : '' }}" 
                              href="{{ request()->fullUrlWithQuery(['divisi' => $div]) }}">
                                {{ ucfirst($div) }}
                            </a>
                        @endforeach
                    </div>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                </form>
                
                <!-- Export Button -->
                <a href="" class="btn btn-info btn-sm">
                  Export Excel
                </a>
              </div>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalForm">
                Tambah User
              </button>

              <!-- Form Modal -->
              <div class="modal fade" id="exampleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalFormTitle">Tambah User</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form method="POST" action="{{ route('admin.user.store') }}">
                                @csrf
                                <div class="form-group">
                                  <label for="name">Nama Lengkap</label>
                                  <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Masukkan Nama lengkap">
                                </div>
                                <div class="form-group">
                                            <label for="divisi" >Divisi</label>
                                            <select name="divisi" id="divisi" required class="form-control">
                                                <option value="inti">Inti</option>
                                                <option value="acara">Acara</option>
                                                <option value="pubdok">Pubdok</option>
                                                <option value="perlengkapan">Perlengkapan</option>
                                                <option value="humas">Humas</option>
                                            </select>
                                        </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Email address</label>
                                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"
                                    placeholder="Masukkan email">
                                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Password</label>
                                  <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
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
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>                 
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                 @php $counter = ($users->currentPage() - 1) * $users->perPage() + 1; @endphp
                <tbody>
                  @foreach ($users as $u)
                  <tr>
                    <td scope="row">{{$counter}}.</td>
                    <td>{{$u->name}}</td>
                    <td>{{$u->email}}</td>
                    <td>{{$u->created_at}}</td>
                    <td>{{$u->updated_at}}</td>
                    <th class="text-center d-flex justify-content-center">
                      <a href="{{ route('admin.user.edit', $u->id) }}">
                        <i class="mdi mdi-open-in-new"></i>
                      </a>
                      <form id="deleteForm{{ $u->id }}" action="{{ route('admin.user.delete', $u->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $u->id }})" >
                            <i class="mdi mdi-close text-danger"></i>
                        </button>
                    </form>

                    </th>            
                  </tr>
                  @php
                    $counter++; // Tingkatkan nilai nomor baris setiap kali loop
                  @endphp
                  @endforeach
                </tbody>
                @include('includes.notification')
                <p class="text-muted mt-2 mb-0">
                  Menampilkan <strong>{{ $users->count() }}</strong> dari total <strong>{{ $totalUsers }}</strong> user{{ $users->count() === 1 ? '' : 's' }}.
                </p>
              </table>
              <div class="mt-4">
                  {{ $users->links() }}
                </div>
              <script>
                function confirmDelete(id) {
                  Swal.fire({
                    title: 'Hapus User?',
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


@endsection