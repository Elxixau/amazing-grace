@extends('layouts.admin')

@section('title', 'Admin Dashboard')


@php
  $breadcrumbItems = [
    ['label' => 'Users', 'url' => route('admin.user.index')],
    ['label' => 'Edit']
  ];
@endphp


@section('content')
<div class="card shadow rounded-4 border-0">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0">Edit Pengguna</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.user.update', $user->id)}}" method="POST"  enctype="multipart/form-data"   >
                        @csrf
                        @method('PUT')

                        @include('includes.notification')
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>

                        <!-- Divisi -->
                        <div class="mb-3">
                            <label for="divisi" class="form-label">Divisi</label>
                            <select class="form-select" id="divisi" name="divisi" required>
                                @foreach(['inti', 'acara', 'pubdok', 'perlengkapan', 'humas'] as $div)
                                    <option value="{{ $div }}" {{ $user->divisi === $div ? 'selected' : '' }}>
                                        {{ ucfirst($div) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (opsional)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                        </div>

                        <div class="form-group"> 
                            <label for="profile_img">Foto Profil</label>
                            
                            <input type="file" name="profile_img" class="form-control-file" accept="image/*">
                            @if($user->profile_img)
                                <img src="{{ asset('storage/' . $user->profile_img) }}" alt="Foto Profil" class="img-thumbnail mb-2" width="120">
                            @endif
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
              </div>
@endsection