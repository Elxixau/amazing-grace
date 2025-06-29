@extends('layouts.admin')

@section('title', 'Page Setting')

@php
  $breadcrumbItems = [
    ['label' => 'Profile Settings', 'url' => route('admin.profile.index')],
  ];
@endphp

@section('content')
 <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Profile Setting</div>
    
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.edit') }}" enctype="multipart/form-data">
                        @csrf

                        @include('includes.notification')

                        <div class="row">
                            {{-- Upload Avatar --}}
                            <div class="mb-3 col-md-6">
                                <label for="profile_img" class="form-label">Avatar:</label>
                                <input id="profile_img" type="file" class="form-control @error('profile_img') is-invalid @enderror" name="profile_img">
                                @error('profile_img')
                                    <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Avatar Preview --}}
                            <div class="mb-3 col-md-6">
                                @if(auth()->user()->profile_img)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_img) }}" style="width: 80px; margin-top: 10px;" alt="Profile Image">
                                @else
                                    <p class="text-muted mt-3">No avatar uploaded.</p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            {{-- Name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Name:</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
                                @error('name')
                                    <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email:</label>
                                <input class="form-control" type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                @error('email')
                                    <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Divisi --}}
                            <div class="mb-3 col-md-6">
                                <label for="divisi" class="form-label">Divisi:</label>
                                <select name="divisi" id="divisi" class="form-control">
                                    @foreach(['inti', 'acara', 'pubdok', 'perlengkapan', 'humas'] as $div)
                                        <option value="{{ $div }}" {{ auth()->user()->divisi == $div ? 'selected' : '' }}>
                                            {{ ucfirst($div) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('divisi')
                                    <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Password (optional):</label>
                                <input class="form-control" type="password" id="password" name="password">
                                @error('password')
                                    <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="row mb-0">
                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


