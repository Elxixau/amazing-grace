@extends('layouts.admin')

@section('title', 'Page Setting')

@php
  $breadcrumbItems = [
    ['label' => 'Costumization', 'url' => route('admin.post.index')],
    ['label' => isset($post) ? 'Edit' : 'Create']
  ];
@endphp


@section('content')
<h3 class="p-4">{{ isset($post) ? 'Edit Post' : 'Buat Post Baru' }}</h3>
    <div class="card shadow-sm rounded-4">
        
        <div class="card-body">
            <form action="{{ isset($post) ? route('admin.post.update', $post->slug) : route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($post)) @method('PUT') @endif

                {{-- 📄 Konten Utama --}}
                <h5 class="">📄 Konten Utama</h5>
                @include('includes.notification')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Sub Judul</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $post->subtitle ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Deskripsi Singkat	</label>
                        <textarea name="excerpt" class="form-control">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tipe Tiket</label>
                        <select name="price" class="form-control">
                            <option value="">-- Pilih Tipe Tiket --</option>
                            <option value="free" {{ old('price', $post->price ?? '') === 'free' ? 'selected' : '' }}>Gratis</option>
                            <option value="berbayar" {{ old('price', $post->price ?? '') === 'berbayar' ? 'selected' : '' }}>Berbayar</option>
                        </select>
                    </div>


                    <div class="col-md-12 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Banner Image</label>
                        @if(isset($post) && $post->banner_image)
                            <img src="{{ asset('storage/' . $post->banner_image) }}" width="150" class="mb-2 d-block">
                            <p class="text-muted small">{{ basename($post->banner_image) }}</p>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remove_banner_image" id="remove_banner_image">
                                <label class="form-check-label" for="remove_banner_image">Hapus gambar ini</label>
                            </div>
                        @endif
                        <input type="file" name="banner_image" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', isset($post) && $post->start_date ? $post->start_date->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Tanggal Berakhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($post)->end_date?->format('Y-m-d')) }}">
                    </div>
                </div>

                {{-- 📍 Informasi Lokasi --}}
                <h5 class="mt-4">📍 Informasi Lokasi</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lokasi</label>
                        <input type="text" name="location_name" class="form-control" value="{{ old('location_name', $post->location_name ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Detail Lokasi</label>
                        <textarea name="location_details" class="form-control">{{ old('location_details', $post->location_details ?? '') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Map Embed URL (iframe)</label>
                         @if(isset($post) && $post->map_embed_url)
                            <div class="embed-responsive embed-responsive-16by9 mt-4 mb-4">
                            <iframe  src="{{ old('map_embed_url', $post->map_embed_url ?? '') }}"></iframe>
                        </div>
                        @endif
                        <textarea name="map_embed_url" class="form-control" rows="3">{{ old('map_embed_url', $post->map_embed_url ?? '') }}</textarea>
                    </div>
                </div>

                {{-- 🕒 Jam Layanan --}}
                <h5 class="mt-4">🕒 Jam Layanan</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jam Layanan Hari Kerja</label>
                        <input type="text" name="weekday_service_hours" class="form-control" value="{{ old('weekday_service_hours', $post->weekday_service_hours ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Jam Layanan Weekend</label>
                        <input type="text" name="weekend_service_hours" class="form-control" value="{{ old('weekend_service_hours', $post->weekend_service_hours ?? '') }}">
                    </div>
                </div>

                {{-- 👤 Informasi Admin --}}
                <h5 class="mt-4">👤 Informasi Admin</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Admin</label>
                        <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name', $post->admin_name ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Foto Admin</label>
                        @if(isset($post) && $post->admin_photo)
                            <img src="{{ asset('storage/' . $post->admin_photo) }}" width="150" class="mb-2 d-block">
                            <p class="text-muted small">{{ basename($post->admin_photo) }}</p>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remove_admin_photo" id="remove_admin_photo">
                                <label class="form-check-label" for="remove_admin_photo">Hapus foto admin</label>
                            </div>
                        @endif

                        <input type="file" name="admin_photo" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>HP Admin</label>
                        <input type="text" name="admin_phone" class="form-control" value="{{ old('admin_phone', $post->admin_phone ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email Admin</label>
                        <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email', $post->admin_email ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>WhatsApp Admin</label>
                        <input type="text" name="admin_whatsapp" class="form-control" value="{{ old('admin_whatsapp', $post->admin_whatsapp ?? '') }}">
                    </div>
                </div>

                {{-- 🔧 Pengaturan --}}
                <h5 class="mt-4">🔧 Pengaturan</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Waktu Publish</label>
                        <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

                {{-- 🏷️ Tags --}}

                <h5 class="mt-4">🏷️ Tags</h5>
                <div class="mb-3">
                    <select name="tags[]" id="tags" class="form-control" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->name }}" {{ (isset($post) && $post->tags->contains('name', $tag->name)) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🎤 Guest Stars --}}
                <h5 class="mt-4">🎤 Guest Stars</h5>
                <div id="guest-stars">
                    @php $guestStars = old('guest_stars', isset($post) ? $post->guestStars : []); @endphp
                    @foreach($guestStars as $index => $star)
                        @include('admin.posts.partials.guest_star', ['index' => $index, 'star' => $star])
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="addGuestStar()">+ Tambah Guest Star</button>

                <button class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>

    </div> 
<script>
    let guestIndex = {{ isset($guestStars) ? count($guestStars) : 0 }};

    function addGuestStar() {
        fetch(`/admin/posts/guest-star-template/${guestIndex}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('guest-stars').insertAdjacentHTML('beforeend', html);
                guestIndex++;
            });
    }
</script>



@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tags').select2({
            tags: true,
            width: '100%',
            tokenSeparators: [',', ' '],
            placeholder: "Pilih atau tambah tag baru"
        });
    });
</script>
@endpush

