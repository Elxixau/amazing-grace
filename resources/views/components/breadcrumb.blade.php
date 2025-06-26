@php
    // Pastikan variabel $items didefinisikan
    $items = $items ?? [];

    // Ambil semua label dari breadcrumb (lowercase)
    $labels = collect($items)->pluck('label')->map(fn($label) => strtolower($label));

    // Tambahkan 'Dashboard' jika belum ada
    if (! $labels->contains('dashboard')) {
        array_unshift($items, ['label' => 'Dashboard', 'url' => route('admin.dashboard')]);
    }
@endphp


    <div class="card card-default">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            @foreach($items as $index => $item)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
    </div>
