{{-- ✅ Alert Success --}}
@if(session('success'))
    <div class="alert alert-success alert-icon d-flex align-items-center" role="alert">
        <i class="mdi mdi-checkbox-marked-outline me-2"></i>
        <p class="mb-0">{{ session('success') }}</p>
    </div>    
@endif

{{-- ❌ Alert Error (custom error from session) --}}
@if(session('error'))
    <div class="alert alert-danger alert-icon d-flex align-items-center" role="alert">
        <i class="mdi mdi-alert-circle-outline me-2"></i>
        <p class="mb-0">{{ session('error') }}</p>
    </div>
@endif

{{-- ⚠️ Alert Warning --}}
@if(session('warning'))
    <div class="alert alert-warning alert-icon d-flex align-items-center" role="alert">
        <i class="mdi mdi-alert-outline me-2"></i>
        <p class="mb-0">{{ session('warning') }}</p>
    </div>
@endif

{{-- ℹ️ Alert Info --}}
@if(session('info'))
    <div class="alert alert-info alert-icon d-flex align-items-center" role="alert">
        <i class="mdi mdi-information-outline me-2"></i>
        <p class="mb-0">{{ session('info') }}</p>
    </div>
@endif

{{-- ❗ Validasi Error (dari $errors) --}}
@if($errors->any())
    <div class="alert alert-danger alert-icon" role="alert">
        <i class="mdi mdi-close-circle-outline me-2"></i>
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
