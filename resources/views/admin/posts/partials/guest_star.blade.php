{{-- resources/views/admin/posts/partials/guest_star.blade.php --}}
@php
    $name = $star['name'] ?? '';
    $role = $star['role'] ?? '';
@endphp

<div class="card mb-2 p-3 border">
    <div class="mb-2">
        <label>Nama Guest Star</label>
        <input type="text" name="guest_stars[{{ $index }}][name]" class="form-control" value="{{ old("guest_stars.$index.name", $name) }}">
    </div>
    <div class="mb-2">
        <label>Role</label>
        <input type="text" name="guest_stars[{{ $index }}][role]" class="form-control" value="{{ old("guest_stars.$index.role", $role) }}">
    </div>
    <div class="mb-2">
        <label>Foto</label>
        <input type="file" name="guest_stars[{{ $index }}][photo]" class="form-control">
    </div>
</div>
